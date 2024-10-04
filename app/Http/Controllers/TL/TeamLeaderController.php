<?php

namespace App\Http\Controllers\TL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
use App\Models\{ProjectTask, Project, TaskReport};
use App\Traits\NotificationTrait;

class TeamLeaderController extends Controller
{
    use NotificationTrait; 

    public function __construct()
    {
        $this->middleware('employee');
    }


    public function TeamIndex(Request $request)
    {
        $employeeID = auth()->guard('employee')->user()->id;
        $teamleavecount = \DB::table('employees')
        ->where('employees.reporting_to', $employeeID)
        ->get();
        $totalleave_count = 0;
        foreach ($teamleavecount as $item) {
            $leaves = \DB::table('leaves')->where('emp_id', $item->id)->where('status', 'pending')->count();
            
            $totalleave_count += $leaves;
        }
       return view('tl.index', compact('totalleave_count'));
    }

    public function TeamTask(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'employee_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();

        $date = now()->format('Y-m-d');

        $documentNames = [];
        $documentPaths = [];

        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $documentPath = 'documents/';

                $fileName = uniqid() . '_' . $file->getClientOriginalName();

                $file->move(public_path($documentPath), $fileName);

                $documentNames[] = $fileName;
                $documentPaths[] = $documentPath . $fileName;
            }
        }

        $input = $request->except('documents');
        $input['date'] = $date;

        
        if (!empty($documentPaths)) {
        
            $input['documents_name'] = implode(',', $documentNames);
            $input['documents_path'] = implode(',', $documentPaths);
        }
        $task = ProjectTask::create($input);
        $usernoti_body = array(
            "title" => "Task Notification",
            "message" => "Task Has been assigned you",
            "image" => "",
        );
        
        $token = [];
     
        $employees = \DB::table('employees')->select('*')->where('id', $request->employee_id)->get();

        foreach ($employees as $employee) {
            if ($employee->fcm_token != '') {
                $token[] = $employee->fcm_token;
            }
        }
   
        if(!empty($token)){
            $this->send_notification($token, $usernoti_body);
        }
        return redirect()->back()->with('success', 'Task has been assigned');
    }


    public function TeamTaskList(Request $request, $id)
    {
        $tasks = ProjectTask::where('project_id', $id)->paginate();
        $project = Project::where('id', $id)->first();

        foreach ($tasks as $task) {

            $task->documents_path =  explode(',', $task->documents_path);
            $task->documents_name =  explode(',', $task->documents_name);
        }

        return view('tl.tasklist', compact('tasks', 'project'));
    }

    public function TeamTaskReport($id)
    {
        $taskreports = TaskReport::where('task_id', $id)
        ->join('employees', 'task_reports.employee_id', 'employees.id')
        ->select('task_reports.*', 'employees.name as emp_name')
        ->orderby('task_reports.id', 'desc')
        ->paginate(10);
        foreach ($taskreports as $report) {
            $report->documents = explode(',',  $report->documents);
        }

        $project = ProjectTask::find($id);

        return view('tl.task_report', compact('taskreports', 'project'));
    }

}
