<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Setting;
use Yajra\DataTables\DataTables;
use Session, DB;

class SettingController extends Controller
{
    public function Setting(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Setting::orderby('created_at', 'desc')->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/setting/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                                // <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>
                        return $btn;
                    })


                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.setting.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function AddSetting(Request $request)
    {
       
        return view('admin.setting.add');
    }

    public function SaveSetting(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'late_coming_time' => 'required',

        ]);

        $input = $request->all();
        unset($input['_token']);
        Setting::create($input);

        return redirect()->back()->with('success', ' Details Added Successfully');
    }

    public function EditSetting($id)
    {
        
        $data = Setting::find($id);


        return view('admin.setting.edit', compact('data'));
    }

    public function UpdateSetting(Request $request, $id)
    {
        // dd($request->all(), $id);

        $request->validate([
            'name' => 'required',
            'late_coming_time' => 'required',

        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Setting::find($id)->update($input);

        return redirect()->back()->with('success', 'Setting  Updated Successfully');
    }


    public function CacheConfiguration()
    {
        return view('admin.setting.cache');
    }

    // public function DeleteShift($id)
    // {
    //     $department = Shift::find($id);

    //     if (!$department) {
    //         // Department not found
    //         return response()->json(['status' => false, 'message' => 'Shift not found'], 404);
    //     }

    //     $department->delete();

    //     return response()->json(['status' => true, 'message' => 'Shift deleted successfully']);
    // }
}
