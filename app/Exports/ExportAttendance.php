<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ExportAttendance implements FromCollection ,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $date;
     protected $employee_id;
     protected $enddate;
 
     public function __construct($date, $enddate, $employee_id)
     {
         $this->date = $date;
         $this->enddate = $enddate;
         $this->employee_id = $employee_id;
     }

    public function collection()
    {
        $date = date('Y-m-d', strtotime($this->date));
        $enddate = date('Y-m-d', strtotime($this->enddate));

        if ($this->employee_id == '0') {
            $attendance_records_pdf = \DB::table('attendance_records')
                ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                ->select('employees.name as employeeName', 'attendance_records.date', 'attendance_records.time_in', 'attendance_records.time_out', 'attendance_records.remark', 'attendance_records.status')
                ->whereBetween('date', [$date , $enddate])
                ->orderby('date', 'asc')
                ->get();


            foreach ($attendance_records_pdf as $single_record) {
                $single_record->date = $single_record->date ? Carbon::parse($single_record->date)->format('j F Y') : '';
                $single_record->time_in = $single_record->time_in ? Carbon::parse($single_record->time_in)->format('h:i A') : '';
                $single_record->time_out = $single_record->time_out ? Carbon::parse($single_record->time_out)->format('h:i A') : '';
               


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
           

            return $attendance_records_pdf;
        } else {
            $attendance_records_pdf = \DB::table('attendance_records')
                ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
                ->select('employees.name as employeeName', 'attendance_records.date', 'attendance_records.time_in', 'attendance_records.time_out', 'attendance_records.remark', 'attendance_records.status')
                ->whereBetween('date', [$date , $enddate])
                ->where('attendance_records.employee_id', $this->employee_id)
                ->get();

               
            foreach ($attendance_records_pdf as $single_record) {
                $single_record->date = $single_record->date ? Carbon::parse($single_record->date)->format('j F Y') : '';
                $single_record->time_in = $single_record->time_in ? Carbon::parse($single_record->time_in)->format('h:i A') : '';
                $single_record->time_out = $single_record->time_out ? Carbon::parse($single_record->time_out)->format('h:i A') : '';
               

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

            return $attendance_records_pdf;
        }
    }

    public function headings(): array
    {
        // Define headings for the exported file
        return [
            'Employee Name',
            'Date',
            'Time In',
            'Time Out',
            'Remark',
            'Status',
            'Total Hours'
        ];
    }
}
