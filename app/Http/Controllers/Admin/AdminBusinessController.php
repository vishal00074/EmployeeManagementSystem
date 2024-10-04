<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Lead, Bid, BidderFeedback, Project};
use Session;
use Carbon\Carbon;

class AdminBusinessController extends Controller
{
    public function Business(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = \DB::table('rules')
                    ->join('employees', 'rules.employee_id', 'employees.id')
                    ->select('employees.name as employee_name', 'rules.*', 'employees.id as employee_id')
                    ->where('type', 'BM')
                    ->where('employees.status', '1')
                    ->get();
                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/bids/view', $row->employee_id) . '" class="btn btn-sm btn-primary">bids</a>
                        <a href="' . url('/admin/leads/view', $row->employee_id) . '" class="btn btn-sm btn-primary">Leads</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }

            return view('admin.business.index');
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }

    public function BidsViews(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $data = Bid::join('employees', 'bids.employee_id', 'employees.id')
                    ->join('upworks', 'bids.upwork_id', 'upworks.id')
                    ->join('agencies', 'bids.agency_id', 'agencies.id')
                    ->select(
                        'upworks.name as upwork_name',
                        'agencies.name as agency_name',
                        \DB::raw(
                            "DATE_FORMAT(bids.date, '%e %M %Y') as date"
                        ),
                        'bids.connects',
                        'bids.status',
                        'bids.url',
                        'bids.id',
                    )
                    ->where('employees.status', '1')
                    ->where('employees.id', $id)
                    ->orderby('bids.id', 'desc');


                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . $row->url . '" class="btn btn-sm btn-primary" target="_blank">Url</a>' .
                            ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="feebback btn btn-sm btn-info">Feedback';
                        $feedback = BidderFeedback::where('business_id', $row->id)->where('type', 'bids')->get();
                        if ($feedback != null) {

                            foreach ($feedback as $item) {
                                $btn .=   '<div class="popup">
                                <strong>Status</strong><p>'. $item->status.'</p>
                                <strong>Feedback</strong><p>'. $item->remark.'</p>
                              </div>';
                            }
                        }

                        $btn .= '</a>';

                        return $btn;
                    })
                    ->filter(function ($instance) use ($request) {
                        $today = Carbon::today();

                        $today = $today->format('Y-m-d');
                        if ($request->get('date')) {
                            $instance->whereDate('date', $request->get('date'));
                        }else{
                            $instance->whereDate('date', $today); 
                        }
                        if (!empty($request->get('search'))) {
                            $instance->where(function ($w) use ($request) {
                                $search = $request->get('search');
                                $w->orWhere('upwork_name', 'LIKE', "%$search%")
                                    ->orWhere('agency_name', 'LIKE', "%$search%");
                            });
                        }
                    })

                    ->rawColumns(['Actions'])
                    ->make(true);
            }
            $employee = \DB::table('employees')->where('id', $id)->first();

            $today = Carbon::today();

            $today = $today->format('Y-m-d');


            $todaysbids_count = Bid::where('employee_id', $id)->whereDate('date', $today)->count();
            $totalbids_count = Bid::where('employee_id', $id)->count();



            $todaysconnects_count = Bid::where('employee_id', $id)->whereDate('date', $today)->sum('connects');
            $totalconnects_count = Bid::where('employee_id', $id)->sum('connects');

            $contractHired = Project::where('assign_by', $id)->whereDate('assign_date',  $today)->count();
            $TotalcontractHired = Project::where('assign_by', $id)->whereDate('assign_date', '<=', $today)->count();

            return view('admin.business.bids', compact('id', 'employee', 'todaysbids_count', 'totalbids_count', 'todaysconnects_count', 'totalconnects_count', 'contractHired', 'TotalcontractHired'));
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }


    public function LeadsViews(Request $request, $id)
    {
        try {

            if ($request->ajax()) {
                $data = Lead::join('employees', 'leads.employee_id', 'employees.id')
                    ->join('upworks', 'leads.upwork_id', 'upworks.id')
                    ->join('agencies', 'leads.agency_id', 'agencies.id')
                    ->select(
                        'upworks.name as upwork_name',
                        'agencies.name as agency_name',
                        'leads.client_name',
                        'leads.remarks',
                        'leads.status',
                        'leads.bid_url'
                    )
                    ->where('employees.status', '1')
                    ->where('employees.id', $id)
                    ->orderby('leads.id', 'desc')
                    ->get();

                return \DataTables::of($data)

                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        if ($row->bid_url != '') {
                            $btn = '<a href="' . $row->bid_url . '" class="btn btn-sm btn-primary" target="_blank">Url</a>';
                            return $btn;
                        }
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }

            $employee = \DB::table('employees')->where('id', $id)->first();

            $today = Carbon::today();
            $today = $today->format('Y-m-d');

            $todaysleads_count = Lead::where('employee_id', $id)->whereDate('created_at', $today)->count();
            $totalleads_count = Lead::where('employee_id', $id)->count();



            return view('admin.business.leads', compact('todaysleads_count', 'id', 'totalleads_count', 'employee'));
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }


    public function BidDataAjax(Request $request)
    {
        try {
            $id = $request->id;
            $employee = \DB::table('employees')->where('id', $id)->first();



            $today = $request->date;


            $todaysbids_count = Bid::where('employee_id', $id)->whereDate('date', $today)->count();
            $totalbids_count = Bid::where('employee_id', $id)->whereDate('date', '<=', $today)->count();



            $todaysconnects_count = Bid::where('employee_id', $id)->whereDate('date', $today)->sum('connects');
            $totalconnects_count = Bid::where('employee_id', $id)->whereDate('date', '<=', $today)->sum('connects');

            $contractHired = Project::where('assign_by', $id)->whereDate('assign_date',  $today)->count();
            $TotalcontractHired = Project::where('assign_by', $id)->whereDate('assign_date', '<=', $today)->count();

            $data = [
                'todaysbids_count' => $todaysbids_count,
                'totalbids_count' => $totalbids_count,
                'todaysconnects_count' => $todaysconnects_count,
                'totalconnects_count' => $totalconnects_count,
                'contractHired' => $contractHired,
                'TotalcontractHired' => $TotalcontractHired,
                
            ];

            return response()->json([
                'status' => true,
                'data' => $data

            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function BidderFeedback(Request $request)
    {
        try {
            $input = [
                'business_id' =>  $request->id,
                'remark' =>  $request->remark,
                'status' =>  $request->status,
                'type' =>  $request->type,

            ];
            $is_exists=BidderFeedback::where('business_id', $request->id)->first();
            if($is_exists){
                $is_exists->delete();
            }
            BidderFeedback::create($input);
            return response()->json(['status' => true, 'message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
