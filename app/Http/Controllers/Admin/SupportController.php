<?php

namespace App\Http\Controllers\Admin;


use App\Models\Support;
use App\Models\Project;
use App\Models\Employee;

 
use App\Models\SupportMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{

 public function Support(Request $request)
  {
    try {
        if ($request->ajax()) {
            $data = Support::join('employees', 'supports.employee_id', '=', 'employees.id')
                ->select(
                    'supports.*', // Select all columns from the supports table
                    'employees.name as employee_name' // Select the name column from the employees table
                )
                ->orderBy('supports.created_at', 'desc')
                ->get();

            return \DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Actions', function ($row) {
                    $btn = '<a href="' . url('/admin/support/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    $btn .= '<a href="' . url('admin/support/add') . '"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Message</button></a>';
                    return $btn;
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }

        return view('admin.support.index');
    } catch (\Exception $e) {
        Session::flash('error', $e->getMessage());
        return redirect('admin/');
    }
}






	public function changeStatus(Request $request, $id)
		{
		    $request->validate([
		        'status' => 'required|in:open,processing,closed'
		    ]);

		    $support = Support::findOrFail($id);
		    $support->status = $request->status;
		    $support->save();

		    return response()->json(['message' => 'Status changed successfully.']);
		}



    public function AddSupport(Request $request)
    {
        
        $data = Support::findOrFail($request->id);

         $employees = Employee::where('name', $request->employee_name)->get();
         $recipientId	= $employees[0]['id'];
         $supportId = $request->id;

           $supportDetails = SupportMessage::where('support_id',$request->id)->get();
          //dd($supportDetails);
        $employeeName =  $request->employee_name;



        return view('admin.support.support_message',compact('recipientId','supportId','data','supportDetails', 'employeeName'));
    }


     public function viewSupportMessage(Request $request)
      {

        // dd($request);

        $supportDetails = SupportMessage::where('support_id',$request->id)->orderBy('created_at', 'ASC')->get();
          // dd($supportDetails);
        $employeeName =  $request->employee_name;

         return view('admin.support.support_message',compact('supportDetails', 'employeeName'));
      }



    public function SaveSupport(Request $request)
    {
        // dd($request);

        $request->validate([
            'message' => 'required',
            
        ]);


        $input = $request->all();
       
        unset($input['_token']);
        SupportMessage::create($input);

        return redirect()->back()->with('success', 'Support Ticket Added Successfully');
    }

     public function deleteMessage($id) {
             // dd($id);
            $post = SupportMessage::find($id);

            if (!$post) {
                return redirect()->back()->with('error', 'Post not found.');
            }
 
            try {
                $post->delete();
                return redirect()->back()->with('success', 'Message deleted successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to delete Message.');
            }
      }


    // public function EditSupport($id)
    //  {
    //     $data = Project::find($id);
    //     $employees = Employee::where('status', 1)->get();
    //     $agency = Agency::where('status', 1)->get();
    //     $departments = Department::where('status', 1)->select('id', 'name', 'tl_name')->get();
    //     $upworks = Upwork::where('status', 1)->get();

    //     return view('admin.support.edit', compact('data', 'employees', 'departments', 'upworks', 'agency'));
    //  }




    // public function UpdateSupport(Request $request, $id)
    //  {
    //     $request->validate([
    //         'project_name' => 'required',
    //         'client_name' => 'required',
    //         'upwork_id' => 'required',
    //         'project_type' => 'required',
    //         'department' => 'required',
    //         'emp_name' => 'required',
    //         'project_description' => 'required',
    //         'assign_by' => 'required',
    //         'assign_date' => 'required',
    //         'project_status' => 'required',

    //     ]);

    //     $employees = implode(',', $request->emp_name);


    //     if ($request->input('project_status') == 'Completed' && $request->input('star_rating')) {
    //         $starRating = $request->input('star_rating');
    //     } else {
    //         $starRating = null;
    //     }


    //     if ($request->input('project_status') == 'Completed' && $request->input('feedback_comment')) {
    //         $feedback = $request->input('feedback_comment');
    //     } else {
    //         $feedback = null; 
    //     }




    //     $input = $request->all();
    //     $input['emp_name'] = $employees; 
    //     $input['star_rating'] = $starRating; 
    //     $input['feedback_comment'] = $feedback; 


    //     unset($input['_token']);
    //     Project::find($id)->update($input);

    //     return redirect()->back()->with('success', 'Support Ticket Data Updated Successfully');
    // }

    // public function DeleteProject($id)
    // {
    //     $project = Project::find($id);

    //     if (!$project) {
    //         return response()->json(['status' => false, 'message' => 'Project not found'], 404);
    //     }

    //     $project->delete();
    //     return response()->json(['status' => true, 'message' => 'Project deleted successfully']);
    // }


    // public function getEmployeesByDepartment(Request $request)
    // {
    //     $departmentId = $request->input('department_id');

    //     $employees = Employee::where('department', $departmentId)->get();

        
    //     return response()->json($employees);
    // }



    // public function fetchUpworkOptions(Request $request)
    // {
    //     $agencyId = $request->input('agencyId');
    //     $upworks = Upwork::where('agency_id', $agencyId)->get();

    //     return response()->json($upworks);
    // }

    // public function task($id)
    // {
    //     $tasks = ProjectTask::where('project_id', $id)->get();

    //     foreach ($tasks as $task) {

    //         $task->documents_path =  explode(',', $task->documents_path);
    //         $task->documents_name =  explode(',', $task->documents_name);
    //     }

    //     // Check if any tasks are found
    //     if ($tasks->isNotEmpty()) {
    //         return view('admin.project.task-view', compact('tasks'));
    //     } else {
    //         // No tasks found, pass empty tasks collection
    //         $tasks = collect();
    //         return view('admin.project.task-view', compact('tasks'));
    //     }
    // }







}
