<?php

namespace App\Http\Controllers\Bidder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{BidderTrait, Ajaxrequest};
use App\Models\Bid;
use Str;
use Carbon\Carbon;

class BidderController extends Controller
{
    use BidderTrait, Ajaxrequest;

    public function BidderIndex(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;


            $is_exists = $this->BidderModule($employeeID);
            if ($is_exists) {
                return view('bidder.index');
            }
            return redirect()->back()->with('error', 'You are unable to access the bidder module.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function MyBid(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;

            if ($request->ajax()) {
                $is_exists = $this->BidderModule($employeeID);
                if (!$is_exists) {
                    return response()->json(['status' => false, 'message' => 'You are unable to access the bidder module.']);
                }
                $data = Bid::join('agencies', 'bids.agency_id', 'agencies.id')
                    ->join('upworks', 'bids.upwork_id', 'upworks.id')
                    ->leftjoin('bidder_feedback', 'bids.id', 'bidder_feedback.business_id')
                    ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'bids.*', 'bidder_feedback.status as feedback_status', 'bidder_feedback.remark')
                    ->where('bids.employee_id', $employeeID);


                if ($request->get('searchdate') == 'Today') {
                    $today = Carbon::now();
                    $format_today =  $today->format('Y-m-d');
                    $data = Bid::join('agencies', 'bids.agency_id', 'agencies.id')
                        ->join('upworks', 'bids.upwork_id', 'upworks.id')
                        ->leftjoin('bidder_feedback', 'bids.id', 'bidder_feedback.business_id')
                        ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'bids.*', 'bidder_feedback.status as feedback_status', 'bidder_feedback.remark')
                        ->where('bids.employee_id', $employeeID)
                        ->where('date', $format_today);
                } else if ($request->get('searchdate') == 'Yesterday') {
                    $yesterday = Carbon::yesterday();
                    $format_yesterday =  $yesterday->format('Y-m-d');
                    $data = Bid::join('agencies', 'bids.agency_id', 'agencies.id')
                        ->join('upworks', 'bids.upwork_id', 'upworks.id')
                        ->leftjoin('bidder_feedback', 'bids.id', 'bidder_feedback.business_id')
                        ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'bids.*', 'bidder_feedback.status as feedback_status', 'bidder_feedback.remark')
                        ->where('bids.employee_id', $employeeID)
                        ->where('date', $format_yesterday);
                } else {
                    $data = Bid::join('agencies', 'bids.agency_id', 'agencies.id')

                        ->join('upworks', 'bids.upwork_id', 'upworks.id')
                        ->leftjoin('bidder_feedback', 'bids.id', 'bidder_feedback.business_id')
                        ->select('agencies.name as agnecy_name', 'upworks.name as upwork_name', 'bids.*', 'bidder_feedback.status as feedback_status', 'bidder_feedback.remark')
                        ->where('bids.employee_id', $employeeID);
                }


                return \DataTables::of($data)
                    ->addIndexColumn()

                    ->addColumn('FeedbackStatus', function ($row) {
                        if ($row->feedback_status == 'approved') {
                            $btn = '<div class="btn btn-info feebback">Approve
                            <div class="popup">
                            <strong>Status</strong><p>' . $row->feedback_status . '</p>
                            <strong>Feedback</strong><p>' . $row->remark . '</p>
                          </div></div>';
                        } else if ($row->feedback_status == 'disapprove') {
                            $btn = '<div class="btn btn-danger feebback">Disapprove 
                            <div class="popup">
                            <strong>Status</strong><p>' . $row->feedback_status . '</p>
                            <strong>Feedback</strong><p>' . $row->remark . '</p>
                          </div></div>';
                        } else {
                            $btn = '';
                        }
                        return $btn;
                    })

                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . $row->url . '" class="btn btn-sm btn-primary"  target="_blank">View</a>';
                        $btn .=  ' <a href="javascript:void(' . $row->id . ')"  data-id="' . $row->id . '" class="delete-customer btn btn-sm btn-danger">Delete</a>';
                        return $btn;
                    })

                    ->filter(function ($instance) use ($request) {

                        if (!empty($request->get('search'))) {
                            $instance->where(function ($w) use ($request) {
                                $search = $request->get('search');
                                $w->orWhere('upworks.name', 'LIKE', "%$search%")
                                    ->orWhere('agencies.name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['Actions', 'FeedbackStatus'])
                    ->make(true);
            }
            return view('bidder.bids.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function MyBidAdd(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;


            $is_exists = $this->BidderModule($employeeID);
            if ($is_exists) {
                return view('bidder.bids.add');
            }
            return redirect()->back()->with('error', 'You are unable to access the bidder module.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function Upwork(Request $request)
    {
        $agency_id = $request->agency_id;
        $upworks = $this->Agency($agency_id);

        return response()->json(['status' => true, 'messsage' => 'success', 'data' => $upworks]);
    }


    public function MyBidSave(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;

            $is_exists = $this->BidderModule($employeeID);
            if (!$is_exists) {
                return redirect()->back()->with('error', 'You are unable to access the bidder module.');
            }
            $count = count($request->agency_id);
            // dd($request->all());

            for ($i = 0; $i < $count; $i++) {

                if ($request->url[$i] == null) {
                    return redirect()->back()->with('error', 'url fields are required');
                }

                if ($request->agency_id[$i] == null) {
                    return redirect()->back()->with('error', 'agency fields are required');
                }

                if ($request->upwork_id[$i] == null) {
                    return redirect()->back()->with('error', 'upwork  fields are required');
                }

                if ($request->connects[$i] == null) {
                    return redirect()->back()->with('error', 'connects  fields are required');
                }

                if ($request->date[$i] == null) {
                    return redirect()->back()->with('error', 'date  fields are required');
                }

                $input = [
                    'url' => $request->url[$i],
                    'agency_id' => $request->agency_id[$i],
                    'upwork_id' => $request->upwork_id[$i],
                    'connects' => $request->connects[$i],
                    'employee_id' => $employeeID,
                    'date' => $request->date[$i],
                    'status' => 'submitted bid',
                ];
                Bid::create($input);
            }

            return redirect()->back()->with('success', 'Bids has been saved');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function DeleteBid($id)
    {
        $Bid = Bid::find($id);

        if (!$Bid) {
            return response()->json(['status' => false, 'message' => 'Bid not found'], 404);
        }

        $Bid->delete();
        return response()->json(['status' => true, 'message' => 'Bid deleted successfully']);
    }
}
