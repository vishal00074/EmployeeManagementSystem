<?php

namespace App\Http\Controllers\Bidder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Project, Employee, Department, Agency, Upwork, ProjectTask};
use Session;
use App\Traits\{BidderTrait, Ajaxrequest};

class ContractController extends Controller
{
    use BidderTrait, Ajaxrequest;

   

    public function Index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $employeeID = auth('employee')->user()->id;
              
                $data = Project::join('upworks', 'upworks.id', '=', 'projects.upwork_id')
                    ->join('departments', 'departments.id', '=', 'projects.department')
                    ->join('employees', 'employees.id', '=', 'projects.emp_name')
                    ->Join('employees as assigners', 'assigners.id', '=', 'projects.assign_by')

                    ->select(
                        'projects.*', // Select all columns from the projects table
                        'upworks.name as upwork_id', // Select the name column from the upworks table
                        'departments.name as department', // Select the name column from the departments table
                        'employees.name as emp_name', // Select the name column from the employees table


                    )
                    ->where('assigners.id', $employeeID)
                    ->orderby('projects.created_at', 'desc')
                    ->get();

                return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/employee/contract/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                         <a href="' . url('/employee/contract/tasks-view', $row->id) . '" class="btn btn-sm btn-warning">Tasks</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }

            return view('bidder.contracts.index');
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' =>  $e->getMessage()]);
        }
    }

    public function ContractAdd(Request $request)
    {
        $employees = Employee::where('status', 1)->get();
        $departments = Department::where('status', 1)->select('id', 'name', 'tl_name')->get();
        $upworks = Upwork::where('status', 1)->get();
        $agency = Agency::where('status', 1)->get();


        return view('bidder.contracts.add', compact('employees', 'departments', 'upworks', 'agency'));
    }


    public function ContractSave(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'upwork_id' => 'required',
            'project_type' => 'required',
            'department' => 'required',
            'emp_name' => 'required',
            'project_description' => 'required',
            'assign_date' => 'required',
            'project_status' => 'required',
        ]);

        $employeeID = auth('employee')->user()->id;
        $employees = implode(',', $request->emp_name);

        $input = $request->all();
        $input['emp_name'] = $employees;
        $input['assign_by'] =  $employeeID;


        unset($input['_token']);
        Project::create($input);

        return redirect()->back()->with('success', 'Project Assigned Successfully');
    }

    public function ContractEdit($id)
    {
        $data = Project::find($id);
        $employees = Employee::where('status', 1)->get();
        $agency = Agency::where('status', 1)->get();
        $departments = Department::where('status', 1)->select('id', 'name', 'tl_name')->get();
        $upworks = Upwork::where('status', 1)->get();


        return view('bidder.contracts.edit', compact('data', 'employees', 'departments', 'upworks', 'agency'));
    }

    public function ContractUpdate(Request $request, $id)
    {

        $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'upwork_id' => 'required',
            'project_type' => 'required',
            'department' => 'required',
            'emp_name' => 'required',
            'project_description' => 'required',
            'assign_date' => 'required',
            'project_status' => 'required',
        ]);


        $employees = implode(',', $request->emp_name);
        $employeeID = auth('employee')->user()->id;

        if ($request->input('project_status') == 'Completed' && $request->input('star_rating')) {
            $starRating = $request->input('star_rating');
        } else {
            $starRating = null;
        }


        if ($request->input('project_status') == 'Completed' && $request->input('feedback_comment')) {
            $feedback = $request->input('feedback_comment');
        } else {
            $feedback = null;
        }

        $input = $request->all();
        $input['emp_name'] = $employees;
        $input['star_rating'] = $starRating;
        $input['feedback_comment'] = $feedback;
        $input['assign_by'] =  $employeeID;

        unset($input['_token']);
        Project::find($id)->update($input);

        return redirect()->back()->with('success', 'Project Data Updated Successfully');
    }
    public function ContractTasks(Request $request, $id)
    {
        $tasks = ProjectTask::where('project_id', $id)->get();

        foreach ($tasks as $task) {
            $task->documents_path =  explode(',', $task->documents_path);
            $task->documents_name =  explode(',', $task->documents_name);
        }

        if ($tasks->isNotEmpty()) {
            return view('bidder.contracts.task-view', compact('tasks'));
        } else {
            $tasks = collect();
            return view('bidder.contracts.task-view', compact('tasks'));
        }
    }
}
