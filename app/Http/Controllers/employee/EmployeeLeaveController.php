<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{AssignLeave, Leave};
use Auth;
use Carbon\Carbon;

class EmployeeLeaveController extends Controller
{
    public function Leave(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $leaves = Leave::select('leaves.*')
            ->where('leaves.emp_id', $employee->id)
            ->orderby('created_at', 'desc')
            ->paginate(10);


        return view('employee.leave', compact('leaves'));
    }

    public function GetApplyLeave(Request $request)
    {
        $id = Auth::guard('employee')->user()->id;
        $date = Carbon::now();
        $date = $date->format('Y-m-d');

        $leaves = \DB::table('assign_leaves')
            ->join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
            ->join('employees', 'assign_leaves.employee_id', 'employees.id')
            ->select('assign_leaves.id as assign_id', 'employees.name as employee_name', 'assign_leaves.days', 'leave_types.name as leave_name', 'assign_leaves.start_date', 'assign_leaves.end_date', 'assign_leaves.used_leave')
            ->where('assign_leaves.employee_id', $id)
            // ->whereDate('assign_leaves.end_date', '>=', $date)
            ->orderby('assign_leaves.created_at', 'desc')
            ->paginate(10);

        foreach ($leaves as $assign) {

            $assign->total_leave = intval($assign->days) - intval($assign->used_leave);
        }

        return view('employee.apply-leave', compact('leaves'));
    }

    public function ApplyLeave(Request $request)
    {

        $this->validate($request, [
            'leave_type' => 'required',
            'assign_id' => 'required',
            'reason' => 'required',
            'date' => 'required|date',
            'day_type' => 'required',
        ]);

        if($request->day_type == '0'){
            $day = 0.5;
        }else{
            $day = 1; 
        }


        $Date = Carbon::parse($request->date);
        

        $employee = Auth::guard('employee')->user();

        // /** Check employee applied previous leave status  */
        // $is_applied = \DB::table('leaves')->where('emp_id', $employee->id)->where('assign_id', $request->assign_id)->where('status', 'pending')->first();
        // if($is_applied){
        //     return redirect()->back()->with('error', 'Your previous leave request is pending');
        // }

        $formattedDate = $Date->format("Y-m-d");
       
         //Assigned Hours
         $assign_hours= \DB::table('assign_leaves')->where('id', $request->assign_id)->first();

         if(!$assign_hours){
            return redirect()->back()->with('error', 'Oops! something went wrong.');
         }

         /** Deduct from total days  */
         $total_balance =  intval($assign_hours->used_leave) + $day;

         if($assign_hours->days < $total_balance){
            return redirect()->back()->with('error', 'You have exceeded your leave balance.');
         }
        
        

        $input = $request->all();
        $input['date'] = $formattedDate;
        $input['day_type'] = $request->day_type;
        $input['emp_id'] = $employee->id;

        Leave::create($input);

        return redirect()->back()->with('success', 'Leave has been submitted');
    }

    public function ApplyLeaveGet(Request $request, $assign_id)
    {
        $employee = Auth::guard('employee')->user();

        $assigned = AssignLeave::join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
            ->select('leave_types.name',  'assign_leaves.id as assign_id', 'assign_leaves.used_leave',
             'assign_leaves.days', 'assign_leaves.start_date', 'assign_leaves.end_date', 'assign_leaves.hours', 'assign_leaves.leave_id')
            ->where('assign_leaves.id', $assign_id)
            ->first();

        $assigned->total_leave = intval($assigned->hours) / 9 ; 

        return view('employee.apply_leave_type', compact('assigned'));
    }

    public function TeamLeave(Request $request)
    {
        $employeeID = auth()->guard('employee')->user()->id;

        $teammember_leave= \DB::table("leaves")
        ->join('employees', 'leaves.emp_id', 'employees.id')
        ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
        ->select('leaves.*' ,'leave_types.name as leave_type_name', 'employees.name as emp_name')
        ->where('employees.reporting_to',  $employeeID)
        ->where('leaves.status',  'pending')
        ->orderby('leaves.created_at', 'desc')
        ->paginate(10);
      
        return view('employee.team-leave', compact('teammember_leave'));

    }

    public function TeamLeaveView(Request $request, $id)
    {
        $data = Leave::find($id);

        $leave_status = \DB::table('assign_leaves')
        ->join('leave_types', 'assign_leaves.leave_id', 'leave_types.id')
        ->select('assign_leaves.*', 'leave_types.name as leave_name')
        ->where('assign_leaves.id', $data->assign_id)
        ->first();

        return view('employee.teamleave-detail', compact('data','leave_status', 'id'));
    }


    public function TeamMemberAction(Request $request, $id)
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
        if($request->status != 'pending' && $request->approved_at == null){
            return redirect()->back()->with('error', 'Approved At field is required');
        }

        if($request->day_type == '0'){
            $day = 0.5;
        }else{
            $day = 1; 
        }

        $input = $request->all();
        // dd( $input);
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
}
