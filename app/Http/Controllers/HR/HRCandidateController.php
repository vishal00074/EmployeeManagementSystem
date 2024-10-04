<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Candidate};

use Yajra\DataTables\DataTables;
use Session;

class HRCandidateController extends Controller
{
    public function HRCandidate(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Candidate::latest()->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('employee/hr/candidate/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                        $btn .=  ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
          
                        return $btn;
                    })

                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('hr.candidate');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('employee/hr/');
        }
    }

    public function HRAddCandidate()
    {
        return view('hr.add-candidate');
    }

    public function HRStoreCandidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048', 
            'status' => 'required',
            'shift' => 'required',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048', 
        ]);

        $input = $request->all();

        $is_exists = \DB::table('candidates')->where('email', $request->email)->first();
        if($is_exists) {
            return redirect()->back()->with('error', 'Candidate email is already exists');
        }

        
        if ($request->hasFile('resume')) {
            $resumeFile = $request->file('resume');
            $resumeFileName = $resumeFile->getClientOriginalName();
            $resumeFilePath = 'candidate/' . $resumeFileName;
            $resumeFile->move(public_path('candidate'), $resumeFileName); 

            $input['resume_path'] = $resumeFilePath;
        }


        if ($request->hasFile('cover_letter')) {
            $coverLetterFile = $request->file('cover_letter');
            $coverLetterFileName = $coverLetterFile->getClientOriginalName();
            $coverLetterFilePath = 'candidate/' . $coverLetterFileName;
            $coverLetterFile->move(public_path('candidate'), $coverLetterFileName); 


            $input['cover_letter_path'] = $coverLetterFilePath;
        }

        unset($input['_token']);
        unset($input['resume']);
        unset($input['cover_letter']);
        Candidate::create($input);

        return redirect()->back()->with('success', 'Data posted Successfully');
    }

    public function HREditCandidate(Request $request, $id)
    {
        $data = Candidate::find($id);
        return view('hr.edit-candidate', compact('data'));
    }

    public function HRUpdateCandidate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'shift' => 'required',
           
           
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Adjust file validation rules as needed
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Adjust file validation rules as needed
        ]);

        $is_exists = \DB::table('candidates')->where('email', $request->email)->where('id', '<>', $id)->first();

        if($is_exists) {
            return redirect()->back()->with('error', 'Candidate email is already exists');
        }

        $candidate = Candidate::findOrFail($id);
        $input = $request->except(['_token', '_method']);

        // Handle resume file upload
        if ($request->hasFile('resume')) {
            $resumeFile = $request->file('resume');
            $resumeFileName = $resumeFile->getClientOriginalName();
            $resumeFilePath = 'candidate/' . $resumeFileName;
            $resumeFile->move(public_path('candidate'), $resumeFileName); // Move the resume file to public/candidate folder

            // Save resume file name and path to database fields
            
            $input['resume_path'] = $resumeFilePath;
        }

        // Handle cover letter file upload
        if ($request->hasFile('cover_letter')) {
            $coverLetterFile = $request->file('cover_letter');
            $coverLetterFileName = $coverLetterFile->getClientOriginalName();
            $coverLetterFilePath = 'candidate/' . $coverLetterFileName;
            $coverLetterFile->move(public_path('candidate'), $coverLetterFileName); // Move the cover letter file to public/candidate folder

            // Save cover letter file name and path to database fields
            
            $input['cover_letter_path'] = $coverLetterFilePath;
        }

        unset($input['resume']);
        unset($input['cover_letter']);

        // Update candidate details
        $candidate->update($input);

        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    public function HRDeleteCandidate(Request $request, $id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return response()->json(['status' => false, 'message' => 'Data not found'], 404);
        }

        $candidate->delete();
        return response()->json(['status' => true, 'message' => 'Data deleted successfully']);
    }
}
