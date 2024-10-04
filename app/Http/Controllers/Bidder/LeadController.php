<?php

namespace App\Http\Controllers\Bidder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{BidderTrait, Ajaxrequest};
use App\Models\Lead;
use Carbon\Carbon;

class LeadController extends Controller
{
    use BidderTrait, Ajaxrequest;

    public function Lead(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;

            if ($request->ajax()) {
                $is_exists = $this->BidderModule($employeeID);
                if (!$is_exists) {
                    return response()->json(['status' => false, 'message' => 'You are unable to access the bidder module.']);
                }
                $data = Lead::join('agencies', 'leads.agency_id', 'agencies.id')
                    ->join('upworks', 'leads.upwork_id', 'upworks.id')
                    ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'leads.*')
                    ->where('leads.employee_id', $employeeID);

                if ($request->get('searchdate') == 'Today') {
                    $today = Carbon::now();
                    $format_today =  $today->format('Y-m-d');
                    $data = Lead::join('agencies', 'leads.agency_id', 'agencies.id')
                        ->join('upworks', 'leads.upwork_id', 'upworks.id')
                        ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'leads.*')
                        ->where('leads.employee_id', $employeeID)
                        ->whereDate('leads.created_at', $format_today);
                } else if ($request->get('searchdate') == 'Yesterday') {
                    $yesterday = Carbon::yesterday();
                    $format_yesterday =  $yesterday->format('Y-m-d');
                    $data = Lead::join('agencies', 'leads.agency_id', 'agencies.id')
                    ->join('upworks', 'leads.upwork_id', 'upworks.id')
                    ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'leads.*')
                    ->where('leads.employee_id', $employeeID)
                    ->whereDate('leads.created_at', $format_yesterday);
                } else {
                    $data = Lead::join('agencies', 'leads.agency_id', 'agencies.id')
                    ->join('upworks', 'leads.upwork_id', 'upworks.id')
                    ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'leads.*')
                    ->where('leads.employee_id', $employeeID);
                }


                return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . $row->url . '" class="btn btn-sm btn-primary" target="_blank">Link</a>
                         <a href="' . url('employee/lead/edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                        $btn .=  ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })
                    ->filter(function ($instance) use ($request) {
                      
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('upworks.name', 'LIKE', "%$search%")
                                ->orWhere('agencies.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }
            return view('bidder.leads.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function MyLeadAdd()
    {
        $employeeID = auth()->guard('employee')->user()->id;
        $is_exists = $this->BidderModule($employeeID);
        if (!$is_exists) {
            return redirect()->back()->with('error', 'You are unable to access the bidder module.');
        }
        return view('bidder.leads.add');
    }

    public function MyleadSave(Request $request)
    {
        try {
            $input = $request->all();
            $employeeID = auth()->guard('employee')->user()->id;
            $is_exists = $this->BidderModule($employeeID);
            if (!$is_exists) {
                return redirect()->back()->with('error', 'You are unable to access the bidder module.');
            }
            unset($input['_token']);
            $input['employee_id'] = $employeeID;
            Lead::create($input);

            return redirect()->back()->with('success', 'lead Saved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function LeadEdit($id)
    {
        $employeeID = auth()->guard('employee')->user()->id;
        $is_exists = $this->BidderModule($employeeID);
        if (!$is_exists) {
            return redirect()->back()->with('error', 'You are unable to access the bidder module.');
        }
        $data = Lead::find($id);
        return view('bidder.leads.edit', compact('data'));
    }

    public function LeadUpdate(Request $request, $id)
    {
        $employeeID = auth()->guard('employee')->user()->id;
        $is_exists = $this->BidderModule($employeeID);
        if (!$is_exists) {
            return redirect()->back()->with('error', 'You are unable to access the bidder module.');
        }
        $input = $request->all();
        unset($input['_token']);
        $input['employee_id'] = $employeeID;

        $data = Lead::find($id)->update($input);
        return redirect()->back()->with('success', 'lead Updated successfully');
    }


    public function Deletelead($id)
    {
        $Lead = Lead::find($id);

        if (!$Lead) {
            return response()->json(['status' => false, 'message' => 'Bid not found'], 404);
        }

        $Lead->delete();
        return response()->json(['status' => true, 'message' => 'Bid deleted successfully']);
    }
}
