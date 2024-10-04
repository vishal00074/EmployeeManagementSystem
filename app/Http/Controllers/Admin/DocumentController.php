<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{ExportAttendance, MonthlyAttendanceExport};

class DocumentController extends Controller
{
    public function AttendencePDFDocument($date, $enddate, $employee_id)
    {
        try {

            $date = date('Y-m-d', strtotime($date));

            if ($employee_id == '0') {
                $attendance_records_pdf = \DB::table('attendance_records')
                    ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                    ->select('employees.name as employeeName', 'attendance_records.*')
                    ->whereBetween('date', [$date , $enddate])
                    ->orderby('date', 'asc')
                    ->get();
                $employeeName = 'All Employees';    


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

                $pdf = PDF::loadView('admin.attendence.pdf.downloadpdf', compact('attendance_records_pdf', 'date', 'enddate', 'employeeName'))->setOptions(['defaultFont' => 'sans-serif']);;

                return $pdf->download('attendance.pdf');

            } else {
                $attendance_records_pdf = \DB::table('attendance_records')
                    ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                    ->select('employees.name as employeeName', 'attendance_records.*')
                    ->whereBetween('date', [$date , $enddate])
                    ->where('attendance_records.employee_id', $employee_id)
                    ->orderby('date', 'asc')
                    ->get();

                $employeeName = $attendance_records_pdf[0]->employeeName;    

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

                $pdf = PDF::loadView('admin.attendence.pdf.downloadpdf', compact('attendance_records_pdf', 'date', 'enddate', 'employeeName'))->setOptions(['defaultFont' => 'sans-serif']);;

                return $pdf->download('attendance.pdf');
            }
        } catch (\Exception $e) {
           dd($e->getMessage());// return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  AttendenceExcelDocument($date,  $enddate, $employee_id)
    {
        try {
           
            return Excel::download(new ExportAttendance($date,  $enddate,$employee_id), 'attendance.xlsx');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function MonthlyAttendanceExcelDocument($month)
    {

        try {

            $year = Carbon::now()->year;

            $startOfMonth = Carbon::create($year, $month, 1);

            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $dates = [];
            $employeedates = [];
            for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
                $dates[] = $date->format('j F');
                $employeedates[] = [
                    'date' => $date->toDateString(),
                ];
            }

            $date = Carbon::createFromDate($year, $month, 1); // Create a Carbon instance

            // Get the full month name
            $monthName = $date->format('F');

           
            return Excel::download(new MonthlyAttendanceExport($month, $dates), $monthName.'_attendance.xlsx');

        } catch (\Exception $e) {
            dd( $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }
}
