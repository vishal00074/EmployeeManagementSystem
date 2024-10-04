<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Upwork, Agency};
use Yajra\DataTables\DataTables;
use Session, DB;

class UpworkController extends Controller
{
    public function Upwork(Request $request)
    {
        try{
        if ($request->ajax()) {
            $data = Upwork::join('agencies', 'upworks.agency_id', '=', 'agencies.id')
            ->select('upworks.*', 'agencies.name as agency_name')
            ->orderby('upworks.created_at', 'desc')
            ->get();
            return \DataTables::of($data)
                    
                    ->addIndexColumn()
                    ->addColumn('Actions', function($row) {
                        $btn = '<a href="' . url('/admin/upwork/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="javascript:void('. $row->id .')"  data-id="'.$row->id.'" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                 
                  
                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
        }
              
        return view('admin.upwork.index');
        }
        catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
  
    }
    
    public function StoreUpwork(Request $request)
    {
        $agencies = Agency::where('status', '1')->get();
        return view('admin.upwork.add', compact('agencies'));
    }
    
    public function SaveUpwork(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'agency_id' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Upwork::create($input);
        
        return redirect()->back()->with('success', 'Upwork Details Added Successfully');  
    }
    
    public function EditUpwork($id)
    {
        $data = DB::table('upworks')
        ->join('agencies', 'upworks.agency_id', 'agencies.id')
        ->select('upworks.*', 'agencies.name as agency_name')
        ->where('upworks.id', $id)
        ->first();
        $agencies = Agency::where('status', '1')->get();


        return view('admin.upwork.edit', compact('data', 'agencies'));
    }
    
    public function UpdateUpwork(Request $request , $id)
    {
        // dd($request->all(), $id);
        
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'agency_id' => 'required',
            'status' => 'required',
           
        ]);
        
        $input = $request->all();
        unset($input['_token']);
        Upwork::find($id)->update($input);
        
        return redirect()->back()->with('success', 'Upwork Data Updated Successfully'); 
    }
    
    public function DeleteUpwork($id)
    {
        $department = Upwork::find($id);
    
        if (!$department) {
            // Department not found
            return response()->json(['status' => false, 'message' => 'Upwork not found'], 404);
        }
    
        $department->delete();
    
        return response()->json(['status' => true, 'message' => 'Upwork deleted successfully']);
        }
}
