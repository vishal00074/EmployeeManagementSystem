<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Employee, Department, Designation, Shift};
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Session, DB, Hash;


class EmployeeController extends Controller
{
    public function Employee(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('employees')
                ->join('designations', 'employees.designation', 'designations.id')
                ->select('employees.*', 'designations.designation_name')
                ->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/employee/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.employee.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function StoreEmployee(Request $request)
    {
        $departments = DB::table('departments')->where('status', '1')->get();
        $designations = DB::table('designations')->where('status', '1')->get();
        $shifts = DB::table('shifts')->get();
        
        $employee_array= [];
        $reporting_to = DB::table('employees')->select('id', 'name')->where('status', '1')->get();
        
        foreach( $reporting_to as  $reporting){
             $employee_array[] = [
            'id'=> $reporting->id,
            'name'=> $reporting->name
            ];
            
        }
        $employee_array[] = [
            'id'=> '0',
            'name'=> 'Admin'
            ];
        return view('admin.employee.add', compact('departments', 'designations', 'shifts', 'employee_array'));
    }

    public function SaveEmployee(Request $request)
    {
        try{
        $request->validate([
            'name' => 'required',
             'employee_id' => 'required',

            'sex' => 'required',
            'dob' => 'required',
            'joining_date' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'current_address' => 'required',
            'permanant_address' => 'required',
            'mobile_number' => 'required',
            'personal_email' => 'required',
            'adhar_number' => 'required',
            // 'pan_number' => 'required',
            'working_saturday' => 'required',
            'shift' => 'required',
            'status' => 'required',
            'reporting_to' => 'required',
            'official_email' => 'required',
            'password' => 'required',
            'photo' => 'required',
            'gross_salary' => 'required',
        ]);

        $input = $request->all();
        unset($input['_token']);
        $is_already = Employee::where('official_email', $request->official_email)->first();
        if($is_already){
            Session::flash('error', 'Email already exist');
        return redirect()->back(); 
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/photo'), $imageName);
            $input['photo']='uploads/photo/'.$imageName;
           
        }
        $input['password']= Hash::make($request->password);
       
        Employee::create($input);

        return redirect()->back()->with('success', 'Employee detail Added Successfully');

    } catch (\Exception $e) {
        Session::flash('error', $e->getMessage());
        return redirect()->back();
    }
    }

    public function EditEmployee($id)
    {
        $departments = DB::table('departments')->where('status', '1')->get();
        $designations = DB::table('designations')->where('status', '1')->get();
        $shifts = DB::table('shifts')->get();

        $data = \DB::table('employees')
        ->join('departments', 'employees.department', 'departments.id')
        ->join('designations', 'employees.designation', 'designations.id')
        ->leftjoin('employees as reporting_emp', 'employees.reporting_to', 'reporting_emp.id')
        ->join('shifts', 'employees.shift', 'shifts.id')
        ->select('employees.*', 'departments.name as department_name', 'designations.designation_name', 'shifts.type', 'reporting_emp.name as reporting_name', 'reporting_emp.id as reporting_id')
        ->where('employees.id', $id)
        ->first();
        // dd($data);
        if( $data->reporting_name == null){
            $data->reporting_name = 'Admin';
            $data->reporting_id = '0';
        }
        
        
         $employee_array= [];
        $reporting_to = DB::table('employees')->select('id', 'name')->where('status', '1')->get();
        
        foreach( $reporting_to as  $reporting){
             $employee_array[] = [
            'id'=> $reporting->id,
            'name'=> $reporting->name
            ];
            
        }
        $employee_array[] = [
            'id'=> '0',
            'name'=> 'Admin'
            ];

        // dd( $data);
        return view('admin.employee.edit', compact('data', 'departments', 'designations', 'shifts', 'employee_array'));
    }

    public function UpdateEmployee(Request $request, $id)
    {
        // dd($request);
      
        $request->validate([
             'employee_id' => 'required',

            'name' => 'required',
            'sex' => 'required',
            'dob' => 'required',
            'joining_date' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'current_address' => 'required',
            'permanant_address' => 'required',
            'mobile_number' => 'required',
            'personal_email' => 'required',
            'adhar_number' => 'required',
            'pan_number' => 'required',
            'working_saturday' => 'required',
            'shift' => 'required',
            'status' => 'required',
            'reporting_to' => 'required',
            'official_email' => 'required',
            // 'password' => 'required',
            // 'photo' => 'required',
            'gross_salary' => 'required',

        ]);

        $is_already = Employee::where('official_email', $request->official_email)->where('id', '<>', $id)->first();
        if($is_already){
            Session::flash('error', 'Email already exist');
        return redirect()->back(); 
        }

        $input = $request->all();
        unset($input['_token']);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/photo'), $imageName);
            $input['photo']='uploads/photo/'.$imageName;
           
        }
        if($input['password'] != null || $input['password'] != ''){
            $input['password']=  Hash::make($request->password);
        }else{
            unset($input['password']);
            unset($input['confirm_password']);
        }
     
        Employee::find($id)->update($input);

        return redirect()->back()->with('success', 'Employee Data Updated Successfully');
    }

    public function DeleteEmployee($id)
    {
        $department = Employee::find($id);

        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Employee not found'], 404);
        }

        $department->delete();

        return response()->json(['status' => true, 'message' => 'Employee deleted successfully']);
    }

    public function DepartmentEmployee(Request $request)
    {
        $department_employees = Employee::where('department',$request->departmentID)->get();

        return response()->json(['status' => true, 'data'=> $department_employees]);
    }
}
