<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Designation;
use Session, DB;

class DesignationController extends Controller
{
    public function Designation(Request $request)
    {
        try{
            if ($request->ajax()) {
                
                $data =  Designation::latest()->get();
                return \DataTables::of($data)
                        
                        ->addIndexColumn()
                        ->addColumn('Actions', function($row) {
                            $btn = '<a href="' . url('/admin/designation/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="javascript:void('. $row->id .')"  data-id="'.$row->id.'" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                            $btn.=' <a href="" class="delete-UOM btn btn-sm btn-warning">Employees</a>';
                            return $btn;
                        })
                     
                      
                        ->rawColumns(['Actions'])  // Correct column name here
                        ->make(true);
            }
                  
            return view('admin.designation.index');
            }
            catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return redirect('admin/');
            }
    }

    public function StoreDesignation(Request $request)
    {
        try{
            return view('admin.designation.add');
        }
        catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function SaveDesignation(Request $request)
    {
        $request->validate([
            'designation_name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
       
        Designation::create($input);
        
        return redirect()->back()->with('success', 'Designation Added Successfully');  
    }

    public function EditDesignation(Request $request, $id)
    {
        $data = Designation::find($id);
        return view('admin.designation.edit', compact('data'));
    }

    public function UpdateDesignation(Request $request, $id)
    {
        $request->validate([
            'designation_name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
       
        Designation::find($id)->update($input);

        return redirect()->back()->with('success', 'Designation Updated Successfully');  
    }

    public function DeleteDesignation($id)
    {
        $department = Designation::find($id);
        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Designation not found'], 404);
        }
    
        $department->delete();
        return response()->json(['status' => true, 'message' => 'Designation deleted successfully']);
    }
}
