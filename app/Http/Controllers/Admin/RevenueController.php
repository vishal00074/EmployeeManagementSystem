<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employee, Department, Upwork, ProjectTask, Agency, Project};

use Yajra\DataTables\DataTables;
use Session;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function RevenueIndex(Request $request)
    {
        try {
            $now = Carbon::now();
            if ($request->date) {
                $today_date =  $request->date;
            } else {
                $today_date =  $now->format('Y-m-d');
            }
            $data = Project::join('upworks', 'upworks.id', '=', 'projects.upwork_id')
                ->join('departments', 'departments.id', '=', 'projects.department')
                ->join('employees', 'employees.id', '=', 'projects.emp_name')
                ->leftJoin('employees as assigners', 'assigners.id', '=', 'projects.assign_by')

                ->select(
                    'projects.*', // Select all columns from the projects table
                    'upworks.name as upwork_id', // Select the name column from the upworks table
                    'departments.name as department', // Select the name column from the departments table
                    'employees.name as emp_name', // Select the name column from the employees table
                    'assigners.name as assign_by',
                    


                )
               ->whereDate('assign_date', '<=', $today_date)
                ->orderby('projects.created_at', 'desc')
                
                ->get();
            
            $totalOfEstimateBilling = 0;
            $totalOfEstimateBillingAmount = 0;

            $FinalOfTotalBillingHours= 0;
            $FinalOfTotalBillingAmount= 0;

            foreach ($data  as $item) {
                if ($item->assign_by == null) {
                    $item->assign_by  = 'Admin';
                }

                // Estimate Billing Detail
                $estimate = \DB::table('project_tasks')->where('project_id', $item->id)
                    ->whereDate('project_tasks.date', $today_date)
                    ->sum('billing_hours');

                if ($item->billing_per_hour_price != null) {
                    $projectamount =  $item->billing_per_hour_price * $estimate;
                } else {
                    $projectamount = '0';
                }

                $item->date = $today_date;
                $item->estimate_billing_hours = $estimate;
                $item->estimate_billing_amount = '$ ' . $projectamount;

                $totalOfEstimateBilling += $item->estimate_billing_hours;
                $totalOfEstimateBillingAmount += $projectamount;




                // Total Billing Hour
                $total = \DB::table('projects')
                    ->join('project_tasks', 'projects.id', 'project_tasks.project_id')
                    ->join('task_reports', 'project_tasks.id', 'task_reports.task_id')
                    ->select("task_reports.*")
                    ->where('projects.id', $item->id)
                    ->whereDate('project_tasks.created_at', $today_date)
                    ->sum('task_billing_hours');

                if ($item->billing_per_hour_price != null) {
                    $totalprojectamount =  $item->billing_per_hour_price * $total;
                } else {
                    $totalprojectamount = '0';
                }

                $item->total_billing_hours = $total;
                $item->total_billing_amount = '$ ' . $totalprojectamount;

                $FinalOfTotalBillingHours += $total;
                $FinalOfTotalBillingAmount += $totalprojectamount;
            }

            $now = Carbon::now();
            if ($request->date) {
                $selecteddate =  $request->date;
            } else {
                $selecteddate =  $now->format('Y-m-d');
            }

            return view('admin.project.project_revenue', compact('data', 'totalOfEstimateBilling', 'totalOfEstimateBillingAmount', 'FinalOfTotalBillingHours', 'FinalOfTotalBillingAmount'));
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' =>  $e->getMessage()]);
        }
    }
}
