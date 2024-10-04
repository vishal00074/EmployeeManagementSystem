<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Yajra\DataTables\DataTables;
use Session;

class DepartmentController extends Controller
{
    public function Department(Request $request)
    {
        try{
        if ($request->ajax()) {
            $data = Department::latest()->get();
            return \DataTables::of($data)
                    
                    ->addIndexColumn()
                    ->addColumn('Actions', function($row) {
                        $btn = '<a href="' . url('/admin/department/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="javascript:void('. $row->id .')"  data-id="'.$row->id.'" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        $btn.=' <a href="" class="delete-UOM btn btn-sm btn-warning">Employees</a>';
                        return $btn;
                    })
                 
                  
                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
        }
              
        return view('admin.department.index');
        }
        catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
  
    }
    
    public function AddDepartment(Request $request)
    {
        return view('admin.department.add');
    }
    
    public function SaveDepartment(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'tl_name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Department::create($input);
        
        return redirect()->back()->with('success', 'Department Added Successfully');  
    }
    
    public function EditDepartment($id)
    {
        $data = Department::find($id);
        return view('admin.department.edit', compact('data'));
    }
    
    public function UpdateDepartment(Request $request , $id)
    {
        // dd($request->all(), $id);
        
        $request->validate([
            'name' => 'required',
            'tl_name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Department::find($id)->update($input);
        
        return redirect()->back()->with('success', 'Department Data Updated Successfully'); 
    }
    
    public function DeleteDepartment($id)
    {
        $department = Department::find($id);
    
        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Department not found'], 404);
        }
    
        $department->delete();
    
        return response()->json(['status' => true, 'message' => 'Department deleted successfully']);
        }
}
