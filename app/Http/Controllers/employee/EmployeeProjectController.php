<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
use App\Models\{ProjectTask, TaskReport, Project, Employee};
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;



class EmployeeProjectController extends Controller
{
    public function Project(Request $request)
    {


        if ($request->ajax()) {
            $employee = Auth::guard('employee')->user();

            $projects = DB::table('projects')
                ->join('employees as emp1', 'projects.emp_name', '=', 'emp1.id')
                ->leftjoin('employees as emp2', 'projects.assign_by', '=', 'emp2.id')
                ->join('departments', 'projects.department', '=', 'departments.id')
                ->join('upworks', 'projects.upwork_id', '=', 'upworks.id')
                ->select('projects.*', 'emp1.name as employee_name', 'emp2.name as assign_by_name', 'departments.name as department_name', 'upworks.name as upwork_name', 'upworks.username as upwork_username')
                ->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])
                ->orderby('projects.id', 'desc')
                ->get();
            foreach ($projects  as $item) {
                if ($item->assign_by_name == null) {
                    $item->assign_by_name  = 'Admin';
                }
            }
            return \DataTables::of($projects)

                ->addIndexColumn()
                ->addColumn('Actions', function ($row) {
                    $is_teamLeader = TeamLeader();
                    $btn = ' <a href="' . url('employee/project/detail/' . $row->id) . '" class="delete-UOM btn btn-sm btn-warning">Detail</a>';
                    if ($is_teamLeader) {
                        $btn .= ' <a href="' . url('employee/tl/project/task/' . $row->id)  . '" class="delete-UOM btn btn-sm btn-primary">Task</a>';
                    }

                    return $btn;
                })


                ->rawColumns(['Actions'])
                ->make(true);
        }


        return view('employee.project');
    }

    public function ProjectDetail(Request $request, $id)
    {
        $employee = Auth::guard('employee')->user();
        $projects = DB::table('projects')
            ->join('employees as emp1', 'projects.emp_name', '=', 'emp1.id')
            ->leftjoin('employees as emp2', 'projects.assign_by', '=', 'emp2.id')
            ->join('departments', 'projects.department', '=', 'departments.id')
            ->join('upworks', 'projects.upwork_id', '=', 'upworks.id')
            ->select('projects.*', 'emp1.name as employee_name', 'emp2.name as assign_by_name', 'departments.name as department_name', 'upworks.name as upwork_name', 'upworks.username as upwork_username')
            ->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0',   [$employee->id])
            ->where('projects.id',  $id)
            ->first();


        if ($projects->assign_by_name == null) {
            $projects->assign_by_name  = 'Admin';
        }


        $now = Carbon::now();
        $today_date =  $now->format('Y-m-d');

        $tasks = DB::table('project_tasks')
            ->join('projects', 'project_tasks.project_id', 'projects.id')
            ->join('employees', 'project_tasks.employee_id', 'employees.id')
            ->select('project_tasks.*')
            ->where('employees.id',  $employee->id)
            ->where('projects.id',  $id)
            ->whereDate('project_tasks.date',  $today_date)
            ->get();



        foreach ($tasks as $task) {

            $task->documents_path =  explode(',', $task->documents_path);
            $task->documents_name =  explode(',', $task->documents_name);
        }

        $project = Project::find($id);
        $emploIds = explode(',', $project->emp_name);

        $employees = Employee::whereIn('id', $emploIds)->where('status', '1')->get();

        return view('employee.project_detail', compact('projects', 'tasks', 'employees'));
    }


    public function ProjectReport(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $date = now()->format('Y-m-d');

        // Initialize empty arrays to store document names and paths
        $documentNames = [];
        $documentPaths = [];

        // Check if documents are uploaded
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Define custom path for storing documents in the public folder
                $documentPath = 'documents/';

                // Generate unique file name
                $fileName = uniqid() . '_' . $file->getClientOriginalName();

                // Move the uploaded file to the specified public folder path
                $file->move(public_path($documentPath), $fileName);

                // Store document name and path in the respective arrays
                $documentNames[] = $fileName;
                $documentPaths[] = $documentPath . $fileName;
            }
        }

        // Create project task with document data
        $input = $request->except('documents');
        $input['date'] = $date;
        $input['employee_id'] = $employee->id;

        if (!empty($documentPaths)) {
            // Convert the arrays of names and paths to strings separated by a delimiter (e.g., comma)
            $input['documents_name'] = implode(',', $documentNames);
            $input['documents_path'] = implode(',', $documentPaths);
        }


        $task = ProjectTask::create($input);

        return redirect()->back()->with('success', 'Task has been updated');
    }

    public function TaskView($id)
    {
        $task = ProjectTask::find($id);
        $taskreport = TaskReport::where('task_id', $id)->get();
        foreach ($taskreport as $report) {
            $report->documents = explode(',',  $report->documents);
        }

        if ($task) {
            return view('employee.task.task_detail', compact('id', 'taskreport', 'task'));
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function SubmitTask(Request $request)
    {
        try {
            $input = $request->all();
            $input['employee_id'] = auth()->guard('employee')->user()->id;

            $documentPaths = [];


            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $documentPath = 'documents/';

                    $fileName = uniqid() . '_' . $file->getClientOriginalName();

                    $file->move(public_path($documentPath), $fileName);


                    $documentPaths[] = $documentPath . $fileName;
                }
            }

            if (!empty($documentPaths)) {
                $input['documents'] = implode(',', $documentPaths);
            }

            TaskReport::create($input);
            return redirect()->back()->with('success', 'Task has been submitted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function TaskList(Request $request)
    {
        try {

            if ($request->ajax()) {
                $employee = Auth::guard('employee')->user();
                $now = Carbon::now();
                $today_date =  $now->format('Y-m-d');

                $tasks = DB::table('project_tasks')
                    ->join('projects', 'project_tasks.project_id', 'projects.id')
                    ->join('employees', 'project_tasks.employee_id', 'employees.id')
                    ->select('project_tasks.*')
                    ->where('employees.id',  $employee->id)
                    ->whereDate('project_tasks.date',  $today_date)
                    ->get();
                    foreach($tasks as $item){
                        $item->date ? Carbon::parse($item->date)->format('l, j F Y') : '';
                    }

                return \DataTables::of($tasks)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $row->documents_path =  explode(',', $row->documents_path);
                        $row->documents_name =  explode(',', $row->documents_name);

                        $btn = ' <a href="' . url('employee/view/task/' . $row->id) . '" class="delete-UOM btn btn-sm btn-warning">Detail</a>';
                        foreach ($row->documents_path as $key => $singleitem) {
                            if(!empty($singleitem)){
                                $btn .= ' <a href="' . url($singleitem) . '" class="delete-UOM btn btn-sm btn-success">View</a>';
                            }
                           
                        }

                        return $btn;
                    })


                    ->rawColumns(['Actions'])
                    ->make(true);
            }


            return view('employee.tasklist');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }




















    //___Learning Purpose
    public function ScienceNews()
    {
        $client = new Client();

        $url = 'https://timesofindia.indiatimes.com/home/science';

        // Send a GET request to the URL
        $crawler = $client->request('GET', $url);

        // Extract information using CSS selectors
        $title = $crawler->filter('title')->text();
        $paragraphs = $crawler->filter('a')->each(function ($node) {
            return [
                'text' => $node->text(),
                'href' => $node->attr('href'),
            ];
        });

        // Display the scraped information
        echo "Title: $title\n";
        echo "Paragraphs:\n";
        foreach ($paragraphs as $paragraph) {
            $href = $paragraph['href'];
            $containsHomeScience = strpos($href, '/home/science/') !== false;

            if ($containsHomeScience) {
                echo "- Text: {$paragraph['text']}, Href: {$paragraph['href']}\n";
            }
        }
    }
}
