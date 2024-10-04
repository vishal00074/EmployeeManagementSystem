<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Yajra\DataTables\DataTables;
use Session, DB;

class ShiftController extends Controller
{
    public function Shift(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Shift::orderby('created_at', 'desc')->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/shift/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                                // <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>
                        return $btn;
                    })


                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.shift.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function StoreShift(Request $request)
    {
   
        return view('admin.shift.add');
    }

    public function SaveShift(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'timing' => 'required',
            'less_hours' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',

        ]);

        $input = $request->all();
        unset($input['_token']);
        Shift::create($input);

        return redirect()->back()->with('success', 'Shift Details Added Successfully');
    }

    public function EditShift($id)
    {
        
        $data = Shift::find($id);


        return view('admin.shift.edit', compact('data'));
    }

    public function UpdateShift(Request $request, $id)
    {
        // dd($request->all(), $id);

        $request->validate([
            'type' => 'required',
            'timing' => 'required',
            'less_hours' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',

        ]);

        $input = $request->all();
        unset($input['_token']);
        Shift::find($id)->update($input);

        return redirect()->back()->with('success', 'Shift Data Updated Successfully');
    }

    public function DeleteShift($id)
    {
        $department = Shift::find($id);

        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Shift not found'], 404);
        }

        $department->delete();

        return response()->json(['status' => true, 'message' => 'Shift deleted successfully']);
    }
}
