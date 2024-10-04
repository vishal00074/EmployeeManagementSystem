<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\{Attendence, NightAttendence, Employee};
use App\Traits\AttendanceTrait;
use Carbon\Carbon;
use Date;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class MonthlyAttendanceExport implements FromCollection, WithHeadings, WithEvents
{
    use AttendanceTrait;

    protected $month;
    protected $dates;



    public function __construct($month, $dates)
    {
        $this->month = $month;
        $this->dates = $dates;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // 
        $employees = \DB::table('employees')->where('status', '1')->select('id', 'name', 'shift', 'working_saturday')->get();

        $now = Carbon::now();
        $monthNumber =   $this->month;

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

            foreach ($employeedates as $key =>  $employeedate) {

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
                    //
                } else {

                    $active_status = $this->AttendanceStatus($first_sign_in,  $last_sign_in, $shift);
                }


                $status[] = $active_status;
                $dynamicKey = 'status_' . $key;

                $employee->$dynamicKey = $active_status;
            }



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

            unset($employee->id);
            unset($employee->shift);
            unset($employee->working_saturday);
        }

        return $employees;
    }

    public function headings(): array
    {
        $heading = ['Employee Name'];


        foreach ($this->dates  as $key => $date) {
            $heading[] = $date;
        }
        $heading_s = [
            'Total Present',
            'Total Leaves',
        ];
        $leaves = [];
        $leave_types = \DB::table('leave_types')->select('*')->get();

        foreach ($leave_types  as  $type) {
            $leaves[] = $type->name;
        }

        $headings = array_merge($heading, $heading_s, $leaves);

        return $headings;
    }

    // Styling and events
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $columnRange = [];

                for ($i = ord('A'); $i <= ord('Z'); $i++) {
                    $columnRange[] = chr($i); // Add single-letter columns
                }

                // Add multi-letter columns (from 'AA' to 'AJ')
                for ($i = ord('A'); $i <= ord('J'); $i++) {
                    $columnRange[] = 'A' . chr($i); // Add double-letter columns
                }
                // Loop through columns and auto-fit them
                foreach ($columnRange as $col) {
                    $sheet->getColumnDimension($col)->setWidth(18);
                }



                $sheet->freezePane('B2'); //This freezes the first column, allowing horizontal scrolling and vertically scrolling


                // Apply a style if the condition is met
                $redstyleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF0000', // Red background
                        ],
                    ],
                ];

                $yellowstyleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00', // Yellow background
                        ],
                    ],
                ];

                $greenstyleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => '00FF00', // Green background
                        ],
                    ],
                ];

                $Hearder_style = [
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFDDDDDD', // Light gray
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ];



                // Loop through each row
                foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                    $applyStyle = false;

                    // Loop through columns B to AJ to check for "Penalty"
                    foreach ($columnRange  as $col) {
                        $cell = $sheet->getCell("{$col}{$rowIndex}");

                        // Check if the cell's value is "Penalty"
                        if ($cell->getValue() === 'Penalty') {
                            $sheet->getStyle("{$col}{$rowIndex}")->applyFromArray($redstyleArray);
                        }

                        if ($cell->getValue() === 'Half Day') {
                            $sheet->getStyle("{$col}{$rowIndex}")->applyFromArray($yellowstyleArray);
                        }

                        if (str_contains($cell->getValue(), 'paid leave')) {
                            $sheet->getStyle("{$col}{$rowIndex}")->applyFromArray($greenstyleArray);
                        }



                        $sheet->getStyle('A1:AJ1')->applyFromArray($Hearder_style);
                    }
                }
            },
        ];
    }
}
