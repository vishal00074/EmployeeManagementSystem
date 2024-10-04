<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PageLength;
use Yajra\DataTables\DataTables;
use Session, DB;

class PageLengthController extends Controller
{
    public function PageLength(Request $request)
     {
        // dd('123');

        try {
            if ($request->ajax()) {
                $data = Pagelength::orderby('created_at', 'desc')->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/setting/pagelength/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                                // <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>
                        return $btn;
                    })


                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.setting.pageLength_index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function AddPageLength(Request $request)
    {
       
        return view('admin.setting.pageLength_add');
    }

    public function SavePageLength(Request $request)
    {


   
        $request->validate([
            'length' => 'required',
 
        ]);


        $input = $request->all();
        unset($input['_token']);
        PageLength::create($input);

        return redirect()->back()->with('success', ' Details Added Successfully');
    }

    public function EditPageLength($id)
    {
        $data = PageLength::find($id);


        return view('admin.setting.pageLength_edit', compact('data'));
    }

    public function UpdatePageLength(Request $request, $id)
    {
        // dd($request->all(), $id);

        $request->validate([
            'length' => 'required',

        ]);
        
        $input = $request->all();
        unset($input['_token']);
        PageLength::find($id)->update($input);

        return redirect()->back()->with('success', 'Setting  Updated Successfully');
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
