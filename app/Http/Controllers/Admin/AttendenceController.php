<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AttendanceTrait;
use App\Models\{Attendence, NightAttendence, Employee};
use Yajra\DataTables\DataTables;
use Session;
use Carbon\Carbon;
use DateTime, DatePeriod, DateInterval;
use Validator;

class AttendenceController extends Controller
{
    use AttendanceTrait;

    public function Attendence(Request $request)
    {
        try {
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
                        $btn = '<a href="' . url('/admin/attendence/calender', $row->id) . '" class="btn btn-sm btn-primary">Attendance</a>';
                        $btn .= ' <a href="' . url('/admin/attendence/records', $row->id) . '" class="delete-UOM btn btn-sm btn-warning">All Record</a>';
                        return $btn;
                    })
                    ->rawColumns(['Actions'])
                    ->make(true);
            }
            return view('admin.attendence.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }



    public function AttendenceCalender($id)
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

            return view('admin.attendence.admin_attendence_calender', compact('combined_array', 'id'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }


    public function MonthlyAttendence($id)
    {
        $indianTime = Carbon::now('Asia/Kolkata');
        $currentMonthStartDate = Carbon::now('Asia/Kolkata')->startOfMonth();
        $currentMonthEndDate = Carbon::now('Asia/Kolkata')->endOfMonth();

        // Retrieve all dates of the current month
        $datesAndDaysInCurrentMonth = [];
        $currentDate = $currentMonthStartDate->copy();
        while ($currentDate <= $currentMonthEndDate) {
            $datesAndDaysInCurrentMonth[] = [
                'date' => $currentDate->copy(),
                'day' => $currentDate->format('l'), // Get the day name
            ];
            $currentDate->addDay(); // Move to the next day
        }
        $monthlyDate = [];
        foreach ($datesAndDaysInCurrentMonth as $dateAndDay) {
            $monthlyDate[] = [
                'date' => $dateAndDay['date']->format('Y-m-d'),
                'day' => $dateAndDay['day'],
            ];
        }
        return view('admin.attendence.monthly', compact('monthlyDate', 'id'));
    }

    public function AttendenceEdit(Request $request)
    {
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

        $input = [
            'employee_id' => $request->employee_id,
            'date' => $request->dateValue,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'status' => '1',
            'ipaddress' => $clientIP,
            'remark' => $request->remark
        ];


        $attendenceRecord = [
            'employee_id' => $request->employee_id,
            'date' => $request->dateValue,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'status' => $active_status,
            'remark' => $request->remark
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
    }


    public function AttendenceRecords(Request $request)
    {
        $employeeID = $request->employee_id;
        $Date = $request->date;

        $records = \DB::table('attendences')
            ->select(\DB::raw("DATE_FORMAT(time_in, '%l:%i %p') as time_in"), \DB::raw("DATE_FORMAT(time_out, '%l:%i %p') as time_out"))
            ->where('employee_id', $employeeID)
            ->where('date', $Date)
            ->orderBy('id', 'asc')
            ->get();

        foreach ($records as $record) {
            if ($record->time_in == null) {
                $record->time_in = '';
            }

            if ($record->time_out == null) {
                $record->time_out = '';
            }
        }


        return response()->json(['status' => true, 'Data' => $records]);
    }


    public function AttendenceRecordPDF()
    {
        $indianTime = Carbon::yesterday('Asia/Kolkata');
        $currentDate = $indianTime->format('Y-m-d');

        $employees = \DB::table('employees')->where('status', '1')->get();

        foreach ($employees as $employee) {

            $first_time_in = \DB::table('attendences')->whereDate('date', $currentDate)->where('employee_id', $employee->id)->orderby('id', 'asc')->first();
            $last_time_out = \DB::table('attendences')->whereDate('date', $currentDate)->where('employee_id', $employee->id)->orderby('id', 'desc')->first();

            $shift = \DB::table('shifts')->where('id', $employee->shift)->first();
            $employee->shift = $shift->type;

            if ($first_time_in) {

                $active_status = $this->AttendanceStatus($first_time_in,  $last_time_out, $shift);

                $input = [
                    'employee_id' => $employee->id,
                    'date' =>  $first_time_in->date,
                    'time_in' => $first_time_in->time_in,
                    'time_out' => $last_time_out->time_out,
                    'remark' => $first_time_in->remark,
                    'status' => $active_status,
                ];

                $attendance_records_pdf = \DB::table('attendance_records')->insert($input);
            }
        }
        \Log::info('Attendance Recorded date ' . $currentDate);
    }


    public function AttendencePDFRecord()
    {
        $employees = \DB::table('employees')->where('status', '1')->get();
        return view('admin.attendence.pdf.get_pdf', compact('employees'));
    }

    public function AjaxAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'enddate' => 'required',
            'employee_id' => 'required',
        ]);


        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json(['status' => false, 'message' =>  $message]);
        }

        $pdflink = 'admin/attendance/pdf/' . $request->date . '/' . $request->enddate . '/' . $request->employee_id;
        $excellink = 'admin/attendance/excel/' . $request->date . '/' . $request->enddate . '/' . $request->employee_id;

        $date = date('Y-m-d', strtotime($request->date));
        $enddate = date('Y-m-d', strtotime($request->enddate));

        if ($request->employee_id == '0') {
            $attendance_records_pdf = \DB::table('attendance_records')
                ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                ->select('employees.name as employeeName', 'attendance_records.*')
                ->whereBetween('date', [$date, $enddate])
                ->get();

            foreach ($attendance_records_pdf as $single_record) {
                $single_record->time_in = $single_record->time_in ? Carbon::parse($single_record->time_in)->format('h:i A') : '';
                $single_record->time_out = $single_record->time_out ? Carbon::parse($single_record->time_out)->format('h:i A') : '';
                $single_record->date = $single_record->date ? Carbon::parse($single_record->date)->format('j F Y') : '';


                $single_record->total_hours = '';
                if ($single_record->time_in && $single_record->time_out) {
                    $timeIn = \Carbon\Carbon::parse($single_record->time_in);
                    $timeOut = \Carbon\Carbon::parse($single_record->time_out);

                    $diff = $timeIn->diff($timeOut);

                    $hours = $diff->h;
                    $minutes = $diff->i;


                    $totalHours = $hours + ($minutes / 60);


                    $formattedHours = sprintf("%d:%02d hours", floor($totalHours), ($totalHours - floor($totalHours)) * 60);

                    $single_record->total_hours = $formattedHours;
                }
            }

            if (count($attendance_records_pdf) > 0) {
                return response()->json(['status' => true, 'message' => 'success', 'data' => $attendance_records_pdf, 'pdflink' => $pdflink, 'excellink' => $excellink]);
            }
            return response()->json(['status' => true, 'message' => 'No data found', 'data' => '']);
        } else {
            $attendance_records_pdf = \DB::table('attendance_records')
                ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                ->select('employees.name as employeeName', 'attendance_records.*')
                ->whereBetween('date', [$date, $enddate])
                ->where('attendance_records.employee_id', $request->employee_id)
                ->get();
            foreach ($attendance_records_pdf as $single_record) {
                $single_record->time_in = $single_record->time_in ? Carbon::parse($single_record->time_in)->format('h:i A') : '';
                $single_record->time_out = $single_record->time_out ? Carbon::parse($single_record->time_out)->format('h:i A') : '';
                $single_record->date = $single_record->date ? Carbon::parse($single_record->date)->format('j F Y') : '';

                $single_record->total_hours = '';
                if ($single_record->time_in && $single_record->time_out) {
                    $timeIn = \Carbon\Carbon::parse($single_record->time_in);
                    $timeOut = \Carbon\Carbon::parse($single_record->time_out);

                    $diff = $timeIn->diff($timeOut);
                    $hours = $diff->h;
                    $minutes = $diff->i;

                    $totalHours = $hours + ($minutes / 60);

                    $formattedHours = sprintf("%d:%02d hours", floor($totalHours), ($totalHours - floor($totalHours)) * 60);

                    $single_record->total_hours = $formattedHours;
                }
            }

            if (count($attendance_records_pdf) > 0) {
                return response()->json(['status' => true, 'message' => 'success', 'data' => $attendance_records_pdf, 'pdflink' => $pdflink, 'excellink' => $excellink]);
            }
            return response()->json(['status' => true, 'message' => 'No data found', 'data' => '']);
        }
    }

    public function AllAttendenceRecords(Request $request, $id)
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
            return view('admin.attendence.all_records', compact('id'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function AttendanceReport(Request $request)
    {
        try {
            $employees = Employee::where('status', '1')->get();
            $now = Carbon::now();
            $monthNumber =  $now->format('m');

            $year = Carbon::now()->year;

            $startOfMonth = Carbon::create($year, $monthNumber, 1);

            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $dates = [];
            $employeedates = [];
            for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
                $dates[] = $date->format('j F');
                $employeedates[] = [
                    'date' => $date->toDateString(),
                    'status' => '',
                ];
            }

            foreach ($employees as  $employee) {
                $status = [];
                foreach ($employeedates as $employeedate) {

                    $first_sign_in = \DB::table('attendences')->where('employee_id',  $employee->id)->whereDate('date', $employeedate['date'])->orderby('id', 'asc')->first();
                    $last_sign_in = \DB::table('attendences')->where('employee_id',  $employee->id)->whereDate('date', $employeedate['date'])->orderby('id', 'desc')->first();
                    $shift = \DB::table('shifts')->where('id', $employee->shift)->first();


                    //Leaves
                    if ($first_sign_in == null && $last_sign_in  == null) {
                        $leave = \DB::table('leaves')
                            ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                            ->select('leave_types.name')
                            ->where('leaves.emp_id',  $employee->id)
                            ->whereDate('leaves.date', $employeedate['date'])
                            ->where('leaves.status', 'approved')
                            ->get();
                        $active_status = '';


                        // Check week Days
                        $carbonDate = Carbon::parse($employeedate['date']);
                        $dayOfWeekNumber = $carbonDate->dayOfWeek;
                        $dayOfWeek = $carbonDate->format('l');

                        $firstDayOfMonth = $carbonDate->copy()->startOfMonth();
                        $firstDayWeek = $firstDayOfMonth->dayOfWeek;

                        $offset = ($dayOfWeekNumber - $firstDayWeek + 7) % 7;

                        $occurrence = 1 + intdiv($carbonDate->day - 1, 7) - intdiv($offset, 7);
                        $strtolower = strtolower($dayOfWeek);
                        $explode_week_days = explode(',', $employee->working_saturday);
                        $weekStatus = '';
                        if ($strtolower == 'saturday') {
                            if (in_array($occurrence, $explode_week_days)) {
                                $weekStatus = 'Working';
                            } else {
                                $weekStatus = 'Not Working';
                            }
                        }

                        if ($leave->isNotEmpty()) {
                            $leaveNames = $leave->pluck('name');

                            $commaSeparatedNames = $leaveNames->implode(',');
                            $active_status =  $commaSeparatedNames . ', ' .  $weekStatus;
                        } else {
                            $active_status = $weekStatus;
                        }
                        ///
                    } else {

                        $active_status = $this->AttendanceStatus($first_sign_in,  $last_sign_in, $shift);
                    }


                    $status[] = $active_status;
                }

                $count = array_count_values($status);
                $records  = $count['Present'] ?? 0;


                $employee->attendance_status =  $status;



                $totalLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->count();

                $paidLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->where('leaves.leave_type', '1')
                    ->count();

                $unpaidLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->where('leaves.leave_type', '2')
                    ->count();
                $employee->total_present =  $records ?? 0;
                $employee->totalLeave =  $totalLeave ?? 0;
                $employee->paidLeave =  $paidLeave ?? 0;
                $employee->unpaidLeave =  $unpaidLeave ?? 0;
            }

            return view('admin.attendence.report', compact('dates', 'employees', 'employeedates', 'monthNumber'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }


    public function AttendanceReportMonthly(Request $request)
    {
        try {
            $employees = Employee::where('status', '1')->get();
            $now = Carbon::now();
            $monthNumber = Carbon::createFromFormat('Y-m', $request->month);
            $monthNumber = $monthNumber->month;

            $year = Carbon::now()->year;

            $startOfMonth = Carbon::create($year, $monthNumber, 1);

            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $dates = [];
            $employeedates = [];
            for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
                $dates[] = $date->format('j F');
                $employeedates[] = [
                    'date' => $date->toDateString(),
                    'status' => '',
                ];
            }

            foreach ($employees as  $employee) {
                $status = [];
                foreach ($employeedates as $employeedate) {

                    $first_sign_in = \DB::table('attendences')->where('employee_id',  $employee->id)->whereDate('date', $employeedate['date'])->orderby('id', 'asc')->first();
                    $last_sign_in = \DB::table('attendences')->where('employee_id',  $employee->id)->whereDate('date', $employeedate['date'])->orderby('id', 'desc')->first();
                    $shift = \DB::table('shifts')->where('id', $employee->shift)->first();

                    //Leaves

                    if ($first_sign_in == null && $last_sign_in  == null) {
                        $leave = \DB::table('leaves')
                            ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                            ->select('leave_types.name')
                            ->where('leaves.emp_id',  $employee->id)
                            ->whereDate('leaves.date', $employeedate['date'])
                            ->where('leaves.status', 'approved')
                            ->get();
                        $active_status = '';

                        // Check week Days
                        $carbonDate = Carbon::parse($employeedate['date']);
                        $dayOfWeekNumber = $carbonDate->dayOfWeek;
                        $dayOfWeek = $carbonDate->format('l');

                        $firstDayOfMonth = $carbonDate->copy()->startOfMonth();
                        $firstDayWeek = $firstDayOfMonth->dayOfWeek;

                        $offset = ($dayOfWeekNumber - $firstDayWeek + 7) % 7;

                        $occurrence = 1 + intdiv($carbonDate->day - 1, 7) - intdiv($offset, 7);
                        $strtolower = strtolower($dayOfWeek);
                        $explode_week_days = explode(',', $employee->working_saturday);
                        $weekStatus = '';
                        if ($strtolower == 'saturday') {
                            if (in_array($occurrence, $explode_week_days)) {
                                $weekStatus = 'Working';
                            } else {
                                $weekStatus = 'Not Working';
                            }
                        }

                        if ($leave->isNotEmpty()) {
                            $leaveNames = $leave->pluck('name');

                            $commaSeparatedNames = $leaveNames->implode(',');
                            $active_status =  $commaSeparatedNames . ', ' .  $weekStatus;
                        } else {
                            $active_status = $weekStatus;
                        }
                        ///
                    } else {

                        $active_status = $this->AttendanceStatus($first_sign_in,  $last_sign_in, $shift);
                    }

                    $status[] = $active_status;
                }

                $employee->attendance_status =  $status;

                $count = array_count_values($status);
                $records  = $count['Present'] ?? 0;

                $totalLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->count();

                $paidLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->where('leaves.leave_type', '1')
                    ->count();

                $unpaidLeave =  \DB::table('leaves')
                    ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
                    ->select('leave_types.name')
                    ->where('leaves.emp_id',  $employee->id)
                    ->whereMonth('leaves.date',  $monthNumber)
                    ->where('leaves.status', 'approved')
                    ->where('leaves.leave_type', '2')
                    ->count();
                $employee->total_present =  $records ?? 0;
                $employee->totalLeave =  $totalLeave ?? 0;
                $employee->paidLeave =  $paidLeave ?? 0;
                $employee->unpaidLeave =  $unpaidLeave ?? 0;
            }

            $responseData = '<table class="table get_month_dates">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Employee Name</th>';

            foreach ($dates as $date) {
                $responseData .= '<th style="min-width: 105px;">' . $date . '</th>';
            }

            $responseData .= '<th style="min-width: 105px;">Total Present</th>';
            $responseData .= '<th style="min-width: 105px;">Total Leave</th>';
            $responseData .= '<th style="min-width: 105px;">Paid Leave</th>';
            $responseData .= '<th style="min-width: 105px;">Unpaid Leave</th>
                    </tr>
                </thead>
            <tbody id="attendance-data">';

            foreach ($employees as $employee) {
                $responseData .= '<tr>';
                $responseData .= '<td>' . $employee->name . '</td>';

                foreach ($employee->attendance_status as $status) {
                    $responseData .= '<td>' . $status . '</td>';
                }

                $responseData .= '<td>' . $employee->total_present . '</td>';
                $responseData .= '<td>' . $employee->totalLeave . '</td>';
                $responseData .= '<td>' . $employee->paidLeave . '</td>';
                $responseData .= '<td>' . $employee->unpaidLeave . '</td>';
                $responseData .= '</tr>';
            }

            $responseData .= '</tbody></table>';
            $link = '<a href="' . url('admin/attendance/export-excel/' . $monthNumber) . '"><button type="button" class="btn btn-primary btn-sm"><i class="icon-plus-circle2 mr-2"></i> Export Excel</button></a>';

            return response()->json(['status' => true, 'data' => $responseData, 'link' => $link]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }






















    public function NightAttendence(Request $request)
    {
        try {
            $indianTime = Carbon::now('Asia/Kolkata');
            $currentDate = $indianTime->format('Y-m-d');
            if ($request->ajax()) {
                $data = \DB::table('employees')
                    ->select('employees.*')
                    ->where('shift', '3')
                    ->where('status', '1')
                    ->get();

                foreach ($data as $item) {
                    $attendence = NightAttendence::where('employee_id', $item->id)
                        ->select('time_in', 'time_out')
                        ->whereDate('time_out', $currentDate)
                        ->first();
                    $item->time_in = '';
                    $item->time_out = '';
                    $item->total_hours = '';
                    if ($attendence) {
                        $item->time_in = $attendence->time_in ? Carbon::parse($attendence->time_in)->format('j F Y h:i A') : '';
                        $item->time_out = $attendence->time_out ? Carbon::parse($attendence->time_out)->format('j F Y h:i A') : '';


                        if ($item->time_in && $item->time_out) {
                            $item->total_hours = \Carbon\Carbon::parse($item->time_in)->diffInHours(\Carbon\Carbon::parse($item->time_out));
                        }
                    }
                }

                return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Actions', function ($row) {
                        $btn = '<a href="' . url('/admin/attendence/night/monthly', $row->id) . '" class="btn btn-sm btn-primary">Monthly</a>';
                        $btn .= ' <a href="' . url('/admin/attendence/nightrecords', $row->id) . '" class="delete-UOM btn btn-sm btn-warning">All Record</a>';
                        return $btn;
                    })


                    ->rawColumns(['Actions'])  // Correct column name here
                    ->make(true);
            }

            return view('admin.attendence.night');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }

    public function NightMonthlyAttendence($id)
    {
        $indianTime = Carbon::now('Asia/Kolkata');
        $currentMonthStartDate = Carbon::now('Asia/Kolkata')->startOfMonth();
        $currentMonthEndDate = Carbon::now('Asia/Kolkata')->endOfMonth();

        // Retrieve all dates of the current month
        $datesAndDaysInCurrentMonth = [];
        $currentDate = $currentMonthStartDate->copy();
        while ($currentDate <= $currentMonthEndDate) {
            $datesAndDaysInCurrentMonth[] = [
                'date' => $currentDate->copy(),
                'day' => $currentDate->format('l'), // Get the day name
            ];
            $currentDate->addDay(); // Move to the next day
        }
        $monthlyDate = [];
        foreach ($datesAndDaysInCurrentMonth as $dateAndDay) {
            $monthlyDate[] = [
                'date' => $dateAndDay['date']->format('Y-m-d'),
                'day' => $dateAndDay['day'],
            ];
        }
        // dd($monthlyDate);
        return view('admin.attendence.nightmonthly', compact('monthlyDate', 'id'));
    }




    public function AllNightAttendenceRecords(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $records = \DB::table('night_attendences')
                    ->join('employees', 'night_attendences.employee_id', 'employees.id')
                    ->select('employees.name', 'night_attendences.*')
                    ->where('employees.id', $id)
                    ->get();

                foreach ($records as $item) {

                    $item->time_in = $item->time_in ? Carbon::parse($item->time_in)->format('j F Y h:i A') : '';
                    $item->time_out = $item->time_out ? Carbon::parse($item->time_out)->format('j F Y h:i A') : '';

                    $item->total_hours = '';
                    if ($item->time_in && $item->time_out) {
                        $item->total_hours = \Carbon\Carbon::parse($item->time_in)->diffInHours(\Carbon\Carbon::parse($item->time_out));
                    }
                }
                return \DataTables::of($records)
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('admin.attendence.all_night_records', compact('id'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('admin/');
        }
    }
}
