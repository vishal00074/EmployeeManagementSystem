<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\{LeaveType, Employee, AssignLeave};
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Session;


class LeaveController extends Controller
{

    public function Leave(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Leave::join('employees', 'leaves.emp_id', 'employees.id')
                    ->select('leaves.*', 'employees.name as employee_name')
                    ->orderby('leaves.created_at', 'desc')
                    ->get();
                foreach ($data as $item) {
                    $leave_type = \DB::table('leave_types')
                        ->where('id', $item->leave_type)
                        ->first();

                    $item->leave_type =  $leave_type->name;
                    if ($item->approved_at != ''){
                        $item->approved_at = Carbon::parse($item->approved_at)->format('j F Y');
                    }
                   
                }


                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/leave/edit', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                        if($row->status != 'approved'){
                            $btn .=       ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        }
                        return $btn;
                    })


                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.leave.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function AddLeave(Request $request)
    {
        $employees = Employee::where('status', 1)->get();
        return view('admin.leave.add', compact('employees'));
    }

    public function SaveLeave(Request $request)
    {

        $request->validate([
            'emp_id' => 'required',
            'leave_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required',
            'status' => 'required',
            'approved_by' => 'required',
            'approved_at' => 'required',

        ]);

        $input = $request->all();
        unset($input['_token']);
        Leave::create($input);

        return redirect()->back()->with('success', 'Leave Added Successfully');
    }

    public function EditLeave($id)
    {
        $data = Leave::find($id);

        $leave_status = \DB::table('assign_leaves')
        ->join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
        ->select('assign_leaves.*', 'leave_types.name as leave_name')
        ->where('assign_leaves.id', $data->assign_id)
        ->first();
       

        return view('admin.leave.edit', compact('data', 'leave_status'));
    }

    public function UpdateLeave(Request $request, $id)
    {
        $request->validate([
            'assign_id' => 'required',
            'emp_id' => 'required',
            'leave_type' => 'required',
            'date' => 'required|date',
            'reason' => 'required',
            'day_type' => 'required',
            'status' => 'required',
           
        ]);

        $input = $request->all();

        if($request->day_type == '0'){
            $day = 0.5;
        }else{
            $day = 1; 
        }

        $leaves= Leave::find($id);
       
        unset($input['_token']);

        if ($request->status == 'approved') {
            $is_appproved = Leave::where('status', 'approved')->where('id', $id)->first();
            if ($is_appproved) {
                return redirect()->back()->with('error', 'Leave already approved');
            }

            $assign_leave= \DB::table('assign_leaves')->where('id', $request->assign_id)->first();
            if(!$assign_leave){
                return redirect()->back()->with('error', 'Oops! something went wrong.');
             }
    
             /** Deduct from total days  */
             $total_balance =  intval($assign_leave->used_leave) + $day;
    
             if($assign_leave->days < $total_balance){
                return redirect()->back()->with('error', 'Employee have exceeded leave balance.');
             }

            
            
            
            $assign_leave= \DB::table('assign_leaves')->where('id', $request->assign_id)->update(['used_leave' =>  $total_balance]);


            Leave::find($id)->update($input);

            return redirect()->back()->with('success', 'Leave Approved Successfully');
        }elseif($request->status == 'rejected'){
            Leave::find($id)->update($input);

            return redirect()->back()->with('success', 'Leave Rejected Successfully');
        }else{
            Leave::find($id)->update($input);

            return redirect()->back()->with('success', 'Leave Data updated Successfully'); 
        }

    }

    public function DeleteLeave($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            // Leave not found
            return response()->json(['status' => false, 'message' => 'Leave not found'], 404);
        }

        $leave->delete();

        return response()->json(['status' => true, 'message' => 'Leave deleted successfully']);
    }

    public function LeaveType()
    {
        $types = LeaveType::paginate(10);
        return view('admin.leave.leave_type', compact('types'));
    }

    public function LeaveTypeSave(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $input = $request->all();
        unset($input['_token']);
        LeaveType::create($input);
        return redirect()->back()->with('success', 'Added Successfully');
    }

    public function LeaveTypeDelete($id)
    {
        $leave = LeaveType::find($id);

        if (!$leave) {
            // Leave not found
            return redirect()->back('error', 'Not Found');
        }

        $leave->delete();

        return redirect()->back()->with('success', 'deleted successfully');
    }

    public function Assignleave(Request $request)
    {
        $leaves = LeaveType::select('*')->get();
        $employees = Employee::where('status', '1')->get();
        return view('admin.leave.assign_leave', compact('leaves', 'employees'));
    }


    public function AssignleaveSave(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'leave_id' => 'required',
            'days' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'

        ]);
        $input = $request->all();
        $hours = intval($request->days) * 9;
        $input['hours'] = $hours;
    

        unset($input['_token']);
        AssignLeave::create($input);
        return redirect()->back()->with('success', 'Leave Assigned successfully');
    }

    public function AssignleaveHistory(Request $request)
    {
        $employees = \DB::table('employees')->where('status', '1')->paginate(10);
        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        foreach ($employees as $assign) {
            $leaves = \DB::table('assign_leaves')
                ->join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
                ->select('assign_leaves.days', 'leave_types.name as leave_name', 'assign_leaves.start_date', 'assign_leaves.end_date', 'assign_leaves.used_leave')
                ->where('assign_leaves.employee_id', $assign->id)
                // ->whereDate('assign_leaves.end_date','>=',  $date)
                // ->whereDate('assign_leaves.start_date','<=',  $date)
                ->get();

            $assign->assigned_leave = $leaves->sum('days');
            $assign->used_leave = $leaves->sum('used_leave');
            $assign->total_leave = intval($assign->assigned_leave) - intval($assign->used_leave);
        }

        return view('admin.leave.assign_leave_history', compact('employees'));
    }

    public function AssignleaveRecord(Request $request, $id)
    {
        $leaves = \DB::table('assign_leaves')
            ->join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
            ->join('employees', 'assign_leaves.employee_id', 'employees.id')
            ->select('employees.name as employee_name', 'assign_leaves.days', 'leave_types.name as leave_name', 'assign_leaves.start_date', 'assign_leaves.end_date', 'assign_leaves.used_leave')
            ->where('assign_leaves.employee_id', $id)
            ->orderby('assign_leaves.created_at', 'desc')
            ->paginate(10);

        foreach ($leaves as $assign) {

            $assign->total_leave = intval($assign->days) - intval($assign->used_leave);
        }
        return view('admin.leave.assign_leave_record', compact('leaves'));
    }
}
