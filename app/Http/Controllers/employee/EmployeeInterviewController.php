<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;

class EmployeeInterviewController extends Controller
{
    public function Interview(Request $request)
    {
        $employee = auth()->guard('employee')->user();

        if ($request->ajax()) {
            $data = \DB::table('interviews')
            ->join('employees', 'interviews.interviewer_name', '=', 'employees.id')
            ->join('departments', 'interviews.department', 'departments.id')
            ->join('candidates', 'interviews.candidate_id', 'candidates.id')
            ->select('candidates.name as candidate_name', 'departments.name as department_name', 'interviews.*')
            ->where('interviews.interviewer_name', $employee->id)
            ->get();
           
           
            return \DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Actions', function ($row) {
                    $btn = '<a href="' . url('/employee/interview/view', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                    return $btn;
                })
                ->rawColumns(['Actions'])  
                ->make(true);
        }
     

        return view('employee.interview');
    }


    public function ViewCandidate(Request $request, $id)
    {
        $data = \DB::table('interviews')
        ->join('employees', 'interviews.interviewer_name', '=', 'employees.id')
        ->join('departments', 'interviews.department', 'departments.id')
        ->join('candidates', 'interviews.candidate_id', 'candidates.id')
        ->select('candidates.name as candidate_name', 'departments.name as department_name', 'interviews.*',
        'candidates.email as candidate_email', 'candidates.phone as candidate_phone', 'candidates.address', 'resume_path', 'cover_letter_path', 'job_applied_for',
        'candidates.status as candidate_status', 'experience', 'position', 'candidates.shift as candidate_shift', 'past_salary', 'expected_salary', 'reason_for_change', 'interview_feedback'
        )
        ->where('interviews.id', $id)
        ->first();
        return view('employee.candidate', compact('data', 'id'));
    }

    public function CandidateFeedback(Request $request, $id)
    {
      $input = $request->all();

      $data = Interview::find($id)->update($input);
      return redirect()->back()->with('success', 'Feedback has been saved');
    }
}
