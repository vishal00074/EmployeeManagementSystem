<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Employee, Department, Upwork, ProjectTask, Agency, Project};

use Yajra\DataTables\DataTables;
use Session;

class ProjectController extends Controller
{

    public function Project(Request $request)
    {
        try {
            if ($request->ajax()) {
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
                        

                    )->orderby('projects.created_at', 'desc')
                    ->get();
                    foreach($data  as $item){
                        if($item->assign_by == null){
                            $item->assign_by  = 'Admin';
                        }
                    }

                return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/project/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                         <a href="' . url('/admin/project/task-view', $row->id) . '" class="btn btn-sm btn-warning">Tasks</a>';
                        $btn .= ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }

            return view('admin.project.index');
        } catch (\Exception $e) {
            return response()->json(['status'=> false, 'message'=>  $e->getMessage()]);
        }
    }

    public function AddProject(Request $request)
    {
        // dd($request);
        $employees = Employee::where('status', 1)->get();
        $departments = Department::where('status', 1)->select('id', 'name', 'tl_name')->get();
        $upworks = Upwork::where('status', 1)->get();
        $agency = Agency::where('status', 1)->get();


        return view('admin.project.add', compact('employees', 'departments', 'upworks', 'agency'));
    }

    public function SaveProjects(Request $request)
    {
        //dd($request);
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

        $input = $request->all();
        $input['emp_name'] = $employees; 
        $input['assign_by'] = 'Admin'; 

       
        unset($input['_token']);
        Project::create($input);

        return redirect()->back()->with('success', 'Project Assigned Successfully');
    }

    public function EditProject($id)
    {
        $data = Project::find($id);
        $employees = Employee::where('status', 1)->get();
        $agency = Agency::where('status', 1)->get();
        $departments = Department::where('status', 1)->select('id', 'name', 'tl_name')->get();
        $upworks = Upwork::where('status', 1)->get();

        return view('admin.project.edit', compact('data', 'employees', 'departments', 'upworks', 'agency'));
    }




    public function UpdateProject(Request $request, $id)
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
        

        unset($input['_token']);
        Project::find($id)->update($input);
        return redirect()->back()->with('success', 'Project Data Updated Successfully');
    }

    public function DeleteProject($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['status' => false, 'message' => 'Project not found'], 404);
        }

        $project->delete();
        return response()->json(['status' => true, 'message' => 'Project deleted successfully']);
    }


    public function getEmployeesByDepartment(Request $request)
    {
        $departmentId = $request->input('department_id');

        $employees = Employee::where('department', $departmentId)->get();

        return response()->json($employees);
    }



    public function fetchUpworkOptions(Request $request)
    {
        $agencyId = $request->input('agencyId');
        $upworks = Upwork::where('agency_id', $agencyId)->get();

        return response()->json($upworks);
    }

    public function task($id)
    {
        $tasks = ProjectTask::where('project_id', $id)->get();

        foreach ($tasks as $task) {

            $task->documents_path =  explode(',', $task->documents_path);
            $task->documents_name =  explode(',', $task->documents_name);
        }

        // Check if any tasks are found
        if ($tasks->isNotEmpty()) {
            return view('admin.project.task-view', compact('tasks', 'id'));
        } else {
            // No tasks found, pass empty tasks collection
            $tasks = collect();
            return view('admin.project.task-view', compact('tasks', 'id'));
        }
    }

    
}
