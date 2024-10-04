<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Project, ProjectTask, Employee, TaskReport};
use App\Traits\TaskTrait;

class AdminTaskController extends Controller
{
    use TaskTrait;

    public function AddTask($id)
    {
        $project = Project::find($id);
        $emploIds =explode(',', $project->emp_name);

        $employees = Employee::whereIn('id', $emploIds)->where('status', '1')->get();
       

        return view('admin.project.task.add', compact('id', 'employees'));
    }

    public function SaveTask(Request $request, $id)
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
        return redirect()->back()->with('success', 'Task has been assigned');
    }

    public function EditTask($id)
    {
        $task = ProjectTask::where('id', $id)->first();
        $employee = Employee::where("id", $task->employee_id)->first();

        return view('admin.project.task.edit_task', compact('task', 'id', 'employee'));
    }

    public function UpdateTask(Request $request, $id)
    {
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

        unset($input['_token']);
        
        $task = ProjectTask::where('id', $id)->update($input);

        return redirect()->back()->with('success', 'Task has been Updated');
    }

    public function TaskDelete($id)
    {
        $task = ProjectTask::find($id);
        if($task){
            $task->delete();
            return response()->json(['status' => true, 'message' =>'Task Deleted Successfully']);
        }else{
            return response()->json(['status' => false, 'message' =>'Oops! Something went wrong']);
        }
    }

    public function TaskReport($id)
    {
        $taskreports = TaskReport::where('task_id', $id)
        ->join('employees', 'task_reports.employee_id', 'employees.id')
        ->select('task_reports.*', 'employees.name as emp_name')
        ->get();
        foreach ($taskreports as $report) {
            $report->documents = explode(',',  $report->documents);
        }

        $project = ProjectTask::find($id);

        return view('admin.project.task.report', compact('taskreports', 'project'));

    }

   
}
