<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HRTrait;
use Carbon\Carbon;
use App\Models\Attendence;
use App\Traits\AttendanceTrait;
use Session;
use DateTime, DatePeriod, DateInterval;

class HRController extends Controller
{
    use HRTrait, AttendanceTrait;

    public function HRIndex(Request $request)
    {
        try {
            $employeeID = auth()->guard('employee')->user()->id;

            $is_exists = $this->HrModule($employeeID);
            if ($is_exists) {
                return view('hr.index');
            }
            return redirect()->back()->with('error', 'You are unable to access the HR module.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function HRAttendance(Request $request)
    {
        try {

            $employeeID = auth()->guard('employee')->user()->id;

            $is_exists = $this->HrModule($employeeID);
            if ($is_exists) {

                $indianTime = Carbon::now('Asia/Kolkata');
                $currentDate = $indianTime->format('Y-m-d');
                if ($request->ajax()) {
                    $data = \DB::table('employees')
                        ->select('employees.*')
                        ->where('status', '1')
                        ->get();

                    foreach ($data as $item) {
                        $attendence = Attendence::where('employee_id', $item->id)
                            ->select('time_in', 'time_out', 'date', 'remark', 'ipaddress')
                            ->where('date', $currentDate)
                            ->first();

                        $time_in = Attendence::where('employee_id', $item->id)
                            ->select('time_in', 'time_out', 'date', 'remark', 'ipaddress')
                            ->orderby('id', 'asc')
                            ->where('date', $currentDate)
                            ->first();


                        $time_out = Attendence::where('employee_id', $item->id)
                            ->select('time_in', 'time_out', 'date', 'remark', 'ipaddress')
                            ->orderby('id', 'desc')
                            ->where('date', $currentDate)
                            ->first();


                        $shift = \DB::table('shifts')->where('id', $item->shift)->first();
                        $item->shift = $shift->type;

                        $item->time_in = '';
                        $item->time_out = '';
                        $item->date = '';
                        $item->remark = '';
                        $item->ipaddress = '';
                        $item->total_hours = '';
                        $item->color = '';

                        if ($attendence) {
                            $item->time_in = $time_in->time_in ? Carbon::parse($time_in->time_in)->format('h:i A') : '';
                            $item->time_out = $time_out->time_out ? Carbon::parse($time_out->time_out)->format('h:i A') : '';
                            $item->date = $attendence->date ? Carbon::parse($attendence->date)->format('j F Y') : '';

                            $item->remark = $attendence->remark;
                            $item->ipaddress = $attendence->ipaddress;

                            $item->time_in_default = $time_in->time_in;
                            $item->time_out_default = $time_out->time_out;


                            /**___ Add Hours for short Leave and Half day __*/

                            $timeIn = Carbon::createFromFormat('H:i:s', $shift->time_in);

                            // Add two hours to the time
                            $timeInWithTwoHoursAdded = $timeIn->addHours(2);

                            // Format the resulting time as needed
                            $formattedTime = $timeInWithTwoHoursAdded->format('H:i:s');


                            if ($time_in->time_in >=  $shift->time_in  &&  $time_in->time_in <= $formattedTime) {
                                $item->color = "#fdfa72";
                            } elseif ($time_in->time_in >=  $shift->time_in) {
                                $item->color = "#FF6F61";
                            } else {
                                $item->color = "lightgreen";
                            }


                            if ($item->time_in && $item->time_out) {
                                $timeIn = \Carbon\Carbon::parse($item->time_in);
                                $timeOut = \Carbon\Carbon::parse($item->time_out);

                                $diff = $timeIn->diff($timeOut);

                                $hours = $diff->h;
                                $minutes = $diff->i;
                                $totalHours = $hours + ($minutes / 60);
                                $formattedHours = sprintf("%d:%02d hours", floor($totalHours), ($totalHours - floor($totalHours)) * 60);
                                $item->total_hours = $formattedHours;
                            }
                        }
                    }
                    return \DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('Actions', function ($row) {
                            $btn = '<a href="' . url('/employee/hr/attendence/calender', $row->id) . '" class="btn btn-sm btn-primary">Attendance</a>';
                            $btn .= ' <a href="' . url('/employee/hr/attendence/records', $row->id) . '" class="delete-UOM btn btn-sm btn-warning">All Record</a>';
                            return $btn;
                        })
                        ->rawColumns(['Actions'])
                        ->make(true);
                }
                return view('hr.attendance');
            }
            return redirect()->back()->with('error', 'You are unable to access the HR module.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function HRCalender(Request $request, $id)
    {
        try {

            $indianTime = Carbon::now('Asia/Kolkata');
            $currentDate = $indianTime->format('Y-m-d');
            $tasks = Attendence::where('employee_id', $id)
                ->where('date', '<', $currentDate)
                ->get()
                ->unique('date');



            $leaves = \DB::table('leaves')->where('status', 'approved')->where('emp_id', $id)->get();

            $dates_between = [];
            $Present = [];
            foreach ($leaves as $leave) {
                $start_date = new DateTime($leave->start_date);
                $end_date = new DateTime($leave->end_date);

                // Include the end date in the list of dates
                $end_date->modify('+1 day');

                $interval = new DateInterval('P1D'); // 1 day interval
                $daterange = new DatePeriod($start_date, $interval, $end_date);

                foreach ($daterange as $date) {
                    $dates_between[] = ['attendence' => "leave", 'date' => $date->format('Y-m-d')];
                }
            }

            foreach ($tasks as $task) {
                $employee = \DB::table('employees')->where('id', $task->employee_id)->first();


                $shift = \DB::table('shifts')->where('id', $employee->shift)->first();
                $task->shift = $shift->type;

                /** First sign in */
                $first_signIN = \DB::table('attendences')
                    ->where('employee_id', $employee->id)
                    ->where('date', $task->date)
                    ->orderby('id', 'asc')
                    ->first();

                /** Last Sign Out */
                $last_signOut = \DB::table('attendences')
                    ->where('employee_id', $employee->id)
                    ->where('date', $task->date)
                    ->orderby('id', 'desc')
                    ->first();

                $active_status = $this->AttendanceStatus($first_signIN,  $last_signOut, $shift);


                $Present[] = ['attendence' => $active_status, 'date' => $task->date];
            }
            $combined_array = array_merge($dates_between, $Present);

            return view('hr.attendence_calender', compact('combined_array', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function HRAttendanceEdit(Request $request)
    {
        try {
            $clientIP = $request->ip();

            $indianTime = Carbon::now('Asia/Kolkata');
            $currentDate = $indianTime->format('Y-m-d');

            $is_attandence = \DB::table('attendences')->where('employee_id', $request->employee_id)->where('date', $request->dateValue)->first();



            $shift = \DB::table('shifts')
                ->join('employees', 'shifts.id', 'employees.shift')
                ->where('employees.id', $request->employee_id)
                ->select('shifts.*')
                ->first();

            if ($request->time_in == '' || $request->time_out == '') {
                return response()->json(['status' => false]);
            }


            $timeIn = Carbon::createFromFormat('H:i', $request->time_in);
            $timeOut = Carbon::createFromFormat('H:i', $request->time_out);

            $formattedTimeIn = $timeIn->format('H:i:s');
            $formattedTimeOut = $timeOut->format('H:i:s');



            $first_signIN = new \stdClass();
            $first_signIN->time_in = $formattedTimeIn;
            $first_signIN->employee_id =  $request->employee_id;
            $first_signIN->date =  $request->dateValue;

            $last_signOut = new \stdClass();
            $last_signOut->time_out = $formattedTimeOut;

            $active_status = $this->AttendanceStatus($first_signIN,  $last_signOut, $shift);
            $remark = $request->remark . ' ' . '(Updated by Hr)';
            $input = [
                'employee_id' => $request->employee_id,
                'date' => $request->dateValue,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'status' => '1',
                'ipaddress' => $clientIP,
                'remark' => $remark
            ];


            $attendenceRecord = [
                'employee_id' => $request->employee_id,
                'date' => $request->dateValue,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'status' => $active_status,
                'remark' => $remark
            ];

            $attendance_records_pdf = \DB::table('attendance_records')
                ->where('date', $request->dateValue)
                ->where('employee_id', $request->employee_id)
                ->update($attendenceRecord);

            if ($is_attandence) {
                Attendence::where('employee_id', $request->employee_id)->where('date', $request->dateValue)->update($input);
                return response()->json(['status' => true]);
            } else {
                Attendence::create($input);
                return response()->json(['status' => true]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function HRAttendanceRecords(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $records = \DB::table('attendences')
                    ->join('employees', 'attendences.employee_id', 'employees.id')
                    ->select('employees.name', 'attendences.*')
                    ->where('employees.id', $id)
                    ->get();

                foreach ($records as $item) {

                    $item->time_in = $item->time_in ? Carbon::parse($item->time_in)->format('h:i A') : '';
                    $item->time_out = $item->time_out ? Carbon::parse($item->time_out)->format('h:i A') : '';
                    $item->date = $item->date ? Carbon::parse($item->date)->format('j F Y') : '';

                    $item->time_in_default = $item->time_in;
                    $item->time_out_default = $item->time_out;


                    $item->total_hours = '';
                    if ($item->time_in && $item->time_out) {
                        $timeIn = \Carbon\Carbon::parse($item->time_in);
                        $timeOut = \Carbon\Carbon::parse($item->time_out);

                        $diff = $timeIn->diff($timeOut);

                        $hours = $diff->h;
                        $minutes = $diff->i;


                        $totalHours = $hours + ($minutes / 60);


                        $formattedHours = sprintf("%d:%02d hours", floor($totalHours), ($totalHours - floor($totalHours)) * 60);

                        $item->total_hours = $formattedHours;
                    }
                }
                return \DataTables::of($records)
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('hr.all_attendance_records', compact('id'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('employee/');
        }
    }
}
