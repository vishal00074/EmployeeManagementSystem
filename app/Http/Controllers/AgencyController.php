<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use Yajra\DataTables\DataTables;
use Session;

class AgencyController extends Controller
{
    public function Agency(Request $request)
    {
        try{
        if ($request->ajax()) {
            $data = Agency::latest()->get();
            return \DataTables::of($data)
                    
                    ->addIndexColumn()
                    ->addColumn('Actions', function($row) {
                        $btn = '<a href="' . url('/admin/agency/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="javascript:void('. $row->id .')"  data-id="'.$row->id.'" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                 
                  
                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
        }
              
        return view('admin.agency.index');
        }
        catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
  
    }
    
    public function StoreAgency(Request $request)
    {
        return view('admin.agency.add');
    }
    
    public function SaveAgency(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Agency::create($input);
        
        return redirect()->back()->with('success', 'Agency Added Successfully');  
    }
    
    public function EditAgency($id)
    {
        $data = Agency::find($id);
        return view('admin.agency.edit', compact('data'));
    }
    
    public function UpdateAgency(Request $request , $id)
    {
        // dd($request->all(), $id);
        
        $request->validate([
            'name' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Agency::find($id)->update($input);
        
        return redirect()->back()->with('success', 'Agency Data Updated Successfully'); 
    }
    
    public function DeleteAgency($id)
    {
        $department = Agency::find($id);
    
        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Department not found'], 404);
        }
    
        $department->delete();
    
        return response()->json(['status' => true, 'message' => 'Department deleted successfully']);
        }
}
