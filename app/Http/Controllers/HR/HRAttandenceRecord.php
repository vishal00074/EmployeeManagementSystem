<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use DateTime, DatePeriod, DateInterval;
use Validator;
use App\Models\Employee;

class HRAttandenceRecord extends Controller
{
    public function AttendanceFile(Request $request)
    {
        return view('hr.attendance.index');
    }

    public function AttendanceFileRecords(Request $request)
    {
        $employees = Employee::where('status', '1')->get();

        return view('hr.attendance.generate_file', compact('employees'));
    }


    public function AjaxAttendanceHR(Request $request)
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

        $pdflink = 'employee/hr/attendance/pdf/' . $request->date . '/' . $request->enddate.'/'.$request->employee_id;
        $excellink = 'employee/hr/attendance/excel/' . $request->date . '/' .$request->enddate.'/'. $request->employee_id;

        $date = date('Y-m-d', strtotime($request->date));
        $enddate = date('Y-m-d', strtotime($request->enddate));

        if ($request->employee_id == '0') {
            $attendance_records_pdf = \DB::table('attendance_records')
                ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                ->select('employees.name as employeeName', 'attendance_records.*')
                ->whereBetween('date', [$date , $enddate])
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
                ->whereBetween('date', [$date , $enddate])
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
}
