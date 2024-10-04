<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Interview, Candidate, Department, Employee};

use Yajra\DataTables\DataTables;
use Session;
use Illuminate\Support\Facades\DB;


class InterviewController extends Controller
{



    public function Interview(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('interviews')
                    ->join('candidates', 'candidates.id', '=', 'interviews.candidate_id')
                    ->join('departments', 'departments.id', '=', 'interviews.department')
                    ->join('employees', 'employees.id', '=', 'interviews.interviewer_name')
                    ->select(
                        'interviews.id',
                        'candidates.name as candidate_name',
                        'departments.name as department_name',
                        'employees.name as interviewer_name',
                        'interviews.interview_date_time',
                        'interviews.interview_status'
                        // Add other columns from the interviews table as needed
                    )
                    ->orderByDesc('interviews.interview_date_time')
                    ->get();

                return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '   <a href="' . url('admin/humanResource/interview/view-interview', $row->id) . '" class="btn btn-sm btn-primary" target="blank">Interview Detail</a>

                              <a href="' . url('/admin/humanResource/interview/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';

                        $btn .=  ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }

            return view('admin.humanResource.interview_index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }


    public function AddInterview(Request $request)
    {
        $candidates = Candidate::all();
        $departments = Department::all();

        return view('admin.humanResource.add_interview', compact('candidates', 'departments'));
    }

    public function getInterviewersByDepartment(Request $request)
    {
        // Fetch interviewers based on the department ID from the request
        $interviewers = Employee::where('department', $request->department_id)->get(['id', 'name']);
        //dd($interviewers);
        // Return interviewers as JSON response
        return response()->json($interviewers);
    }

    public function SaveInterview(Request $request)
    {
        //dd($request);

        $request->validate([
            'candidate_id' => 'required',
            'department' => 'required',
            'interviewer_name' => 'required',
            'interview_date_time' => 'required',
            'interview_status' => 'required',
            'interview_type' => 'required',

        ]);


        $input = $request->all();

        //dd( $input);
        unset($input['_token']);
        Interview::create($input);

        return redirect()->back()->with('success', 'Interview Assigned Successfully');
    }


    public function EditInterview($id)
    {
        $data = Interview::find($id);
        $candidates = Candidate::all();
        $departments = Department::all();
        $interviewers = Employee::all(); // Assuming Employee model for interviewers


        return view('admin.humanResource.edit_interview', compact('data', 'candidates', 'departments', 'interviewers'));
    }


    public function UpdateInterview(Request $request, $id)
    {
        $request->validate([
            'candidate_id' => 'required',
            'department' => 'required',
            'interviewer_name' => 'required',
            'interview_date_time' => 'required',
            'interview_status' => 'required',
            'interview_type' => 'required',

        ]);


        $input = $request->all();


        unset($input['_token']);
        Interview::find($id)->update($input);

        return redirect()->back()->with('success', 'Data Updated Successfully');
    }


    public function DeleteInterview($id)
    {
        $interview = Interview::find($id);

        if (!$interview) {
            return response()->json(['status' => false, 'message' => 'Data not found'], 404);
        }

        $interview->delete();
        return response()->json(['status' => true, 'message' => 'Data deleted successfully']);
    }

    public function viewInterview($id)
    {
        $data = Interview::find($id);

        $candidates = Candidate::all();
        $departments = Department::all();
        $interviewers = Employee::all(); // Assuming Employee model for interviewers


        return view('admin.humanResource.view-interview', compact('data', 'candidates', 'departments', 'interviewers'));
    }
}
