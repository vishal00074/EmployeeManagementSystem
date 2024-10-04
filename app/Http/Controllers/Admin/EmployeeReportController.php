<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employee, Project, ProjectTask, TaskReport};

class EmployeeReportController extends Controller
{
    public function EmployeeReport(Request $request)
    {
        $employees = Employee::where('status', '1')->get();
        foreach ($employees as $employee) {
            $employee->complete_count = Project::where('project_status', 'Completed')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();
            $employee->pending_count = Project::where('project_status', 'Pending')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();
            $employee->inprocessing_count = Project::where('project_status', 'In-Processing')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();
        }

        return view('admin.employee_reports.index', compact('employees'));
    }

    public function EmployeeReportDetail(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = ProjectTask::where('employee_id', $id)->latest()->get();
            return \DataTables::of($data)
                    
                    ->addIndexColumn()
                    ->addColumn('Actions', function($row) {
                        $btn = '<a href="' . url('/admin/employee/task/report', $row->id) . '" class="btn btn-sm btn-primary">Task Report</a>';
                        return $btn;
                    })
                 
                  
                    ->rawColumns(['Actions'])  
                    ->make(true);
        }
       

        $employee = Employee::where('id', $id)->first();
        $employee->complete_count = Project::where('project_status', 'Completed')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();
        $employee->pending_count = Project::where('project_status', 'Pending')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();
        $employee->inprocessing_count = Project::where('project_status', 'In-Processing')->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();


        $employee->total_project = Project::whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])->count();

        $employee->assigned_project_task = ProjectTask::where('employee_id', $id)->count();


        $employee->task_report = TaskReport::where('employee_id', $id)->count();

        $billingHours = TaskReport::where('employee_id', $id)->get();
        $employee->total_billing_hours =   $billingHours->sum('task_billing_hours');
        $employee->total_non_billing_hours = $billingHours->sum('task_non_billing_hours');

        

        return view('admin.employee_reports.report_detail', compact('employee', 'id'));
    }


    public function EmployeeTaskReport(Request $request, $id)
    {
        $data = TaskReport::where('task_id', $id)->get();

        $project_task= ProjectTask::where('id', $id)->first();

        foreach ($data as $report) {
            $report->documents = explode(',',  $report->documents);
        }
            
        return view('admin.employee_reports.task_report_detail', compact('id', 'data', 'project_task'));
    }
}
