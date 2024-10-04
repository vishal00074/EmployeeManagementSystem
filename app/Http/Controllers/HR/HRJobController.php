<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\{HumanResource, Employee, Department, Upwork, ProjectTask, Agency, Project, Candidate};

use Yajra\DataTables\DataTables;
use Session;

class HRJobController extends Controller
{
    public function HRJob(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = HumanResource::latest()->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '   <a href="' . url('/humanResource/job-view', $row->id) . '" class="btn btn-sm btn-primary" target="blank">view job</a>
                          <a href="' . url('employee/hr/humanResource/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';

                        $btn .=  ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })

                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('hr.job-listing');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function HRAddJob(Request $request)
    {
        return view('hr.add-job');
    }

    public function HRAddSave(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'job_position' => 'required',
            'job_type' => 'required',
            'job_location' => 'required',
            'qualification' => 'required',
            'experience' => 'required',
            'job_skill' => 'required',
            'job_description' => 'required',
            'interview_mode' => 'required',
            'key_responsibilities' => 'required',
            'email' => 'required',
            'contact_detail' => 'required',
            'shift' => 'required',
        ]);

        $input = $request->all();

        $shift = \DB::table('shifts')->where('id', $request->shift)->first();

        $input['timing'] = $shift->timing;

        unset($input['_token']);
        HumanResource::create($input);

        return redirect()->back()->with('success', 'Job posted Successfully');
    }

    public function HREditJob(Request $request, $id)
    {
        $data = HumanResource::find($id);
        return view('hr.job-edit', compact('data'));
    }


    public function HrJobUpdate(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'job_position' => 'required',
            'job_type' => 'required',
            'job_location' => 'required',
            'qualification' => 'required',
            'experience' => 'required',
            'job_skill' => 'required',
            'job_description' => 'required',
            'interview_mode' => 'required',
            'key_responsibilities' => 'required',
            'email' => 'required',
            'contact_detail' => 'required',
            'shift' => 'required',


        ]);
        $shift = \DB::table('shifts')->where('id', $request->shift)->first();

        $input = $request->all();
        $input['timing'] = $shift->timing;

        unset($input['_token']);
        HumanResource::find($id)->update($input);

        return redirect()->back()->with('success', 'Job Data Updated Successfully');
    }

    public function HRDeleteJob(Request $request, $id)
    {
        $HumanResource = HumanResource::find($id);

        if (!$HumanResource) {
            return response()->json(['status' => false, 'message' => 'Data not found'], 404);
        }

        $HumanResource->delete();
        return response()->json(['status' => true, 'message' => 'Data deleted successfully']);
    }
}
