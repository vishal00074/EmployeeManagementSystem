<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeDashboardController extends Controller
{
    public function index(Request $request)
    {
        $employeeID = auth()->guard('employee')->user()->id;
        $teamleavecount = \DB::table('employees')
            ->where('employees.reporting_to', $employeeID)
            ->get();
        //  dd($teamleavecount);   
        $totalleave_count = 0;
        foreach ($teamleavecount as $item) {
            $leaves = \DB::table('leaves')->where('emp_id', $item->id)->where('status', 'pending')->count();
            
            $totalleave_count += $leaves;
        }

        $role = \DB::table('rules')->where('employee_id', $employeeID)->orderby('id', 'desc')->first();
       
        return view('employee.dashboard', compact('totalleave_count', 'role'));
    }

    public function EmployeeProfile(Request $request)
    {
        $employee = Employee::join('departments', 'employees.department', 'departments.id')
            ->join('designations', 'employees.designation', 'designations.id')
            ->join('shifts', 'employees.shift', 'shifts.id')
            ->leftjoin('employees as reporting_emp', 'employees.reporting_to', 'reporting_emp.id')
            ->select('employees.*', 'designations.designation_name', 'departments.name as department_name', 'shifts.type', 'shifts.timing', 'reporting_emp.name as reporting_name', 'reporting_emp.id as reporting_id')
            ->where('employees.id', auth()->guard('employee')->user()->id)
            ->first();
        if ($employee->reporting_name == null) {
            $employee->reporting_name = 'Admin';
            $employee->reporting_id = '0';
        }
        //  dd($employee);
        return view('employee.profile', compact('employee'));
    }
}
