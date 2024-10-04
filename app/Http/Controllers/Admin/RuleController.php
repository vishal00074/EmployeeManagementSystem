<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{ Rule, Employee };

use Yajra\DataTables\DataTables;
use Session, DB;

class RuleController extends Controller
{
    public function Rule(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Rule::join('employees', 'rules.employee_id', '=', 'employees.id')
                         ->select('rules.*', 'employees.name as employee_name') // Selecting the employee_name field
                         ->orderBy('created_at', 'desc')
                         ->get();

                return \DataTables::of($data)

                    ->addIndexColumn()
                    

                   



                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/rule/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                              <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })

 
                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }  

            return view('admin.rule.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function StoreRule(Request $request)
    {
        $employee = Employee::where('status', 1)->get();

        return view('admin.rule.add',compact('employee'));
    }

    public function SaveRule(Request $request)
    {
        // dd($request);

        $request->validate([
            'employee_id' => 'required',
            'type' => 'required',

        ]);

        $is_exist = Rule::where('employee_id', $request->employee_id)->first();
        if($is_exist){
            return redirect()->back()->with('error', 'Role has already assigned to this employee');
        }

        $input = $request->all();
        unset($input['_token']);
        Rule::create($input);

        return redirect()->back()->with('success', 'Rule Details Added Successfully');
    }

    public function EditRule($id)
    {
        
        $data = Rule::find($id);
        $employees = Employee::where('status', 1)->get();


        return view('admin.rule.edit', compact('data','employees'));
    }

    public function UpdateRule(Request $request, $id)
    {
        // dd($request->all(), $id);

        $request->validate([
            'employee_id' => 'required',
            'type' => 'required',


        ]);

        $input = $request->all();
        unset($input['_token']);
        Rule::find($id)->update($input);

        return redirect()->back()->with('success', 'Rule Data Updated Successfully');
    }

    public function DeleteRule($id)
    {
        $rule = Rule::find($id);

        if (!$rule) {
            return response()->json(['status' => false, 'message' => 'Rule not found'], 404);
        }

        $rule->delete();

        return response()->json(['status' => true, 'message' => 'Rule deleted successfully']);
    }
}
