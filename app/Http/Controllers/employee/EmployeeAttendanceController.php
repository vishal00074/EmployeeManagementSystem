<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\AttendanceTrait;
use Illuminate\Http\Request;
use App\Models\{Attendence, NightAttendence};
use Auth;
use DateTime, DatePeriod, DateInterval;
use Carbon\Carbon;



class EmployeeAttendanceController extends Controller
{
    use AttendanceTrait;

    public function SignIn(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all(),]);
        }

        /**__Indian Standard Date and Time__*/
        $indianTime = Carbon::now('Asia/Kolkata');

        /**__ Get Time IN and Time Out value according to shift*/
        $shift = \DB::table('shifts')->where('id', auth()->guard('employee')->user()->shift)->first();

        $intless = intval($shift->less_hours);
        $updatedDateTime = $indianTime->subHours($intless);


        /**__ Sign IN updated Time and Date__*/
        $updatedTime = $updatedDateTime->format('H:i:s');
        $updatedDate = $updatedDateTime->format('Y-m-d');


        $employee = Auth::guard('employee')->user();


        /**___ No Use For now____*/
        /** _______Is on leave or not */
        $leaves = \DB::table('leaves')->where('status', 'approved')->where('emp_id', $employee->id)->get();
        // dd( $leaves);
        $dates_between = [];
        // foreach ($leaves as $leave) {
        //     $start_date = new DateTime($leave->start_date);
        //     $end_date = new DateTime($leave->end_date);

        //     $end_date->modify('+1 day');

        //     $interval = new DateInterval('P1D'); // 1 day interval
        //     $daterange = new DatePeriod($start_date, $interval, $end_date);
        //     foreach ($daterange as $date) {
        //         $dates_between[] = ['attendence' => "leave", 'date' => $date->format('Y-m-d')];
        //     }
        // }
        /** ________ */


        $attendance = new Attendence([
            'employee_id' => $employee->id,
            'date' => $updatedDate,
            'time_in' => $updatedTime,
            'status' => '1',
            'remark' => $request->remark,
            'ipaddress' => $request->ip(),
        ]);
        $attendance->save();
        return response()->json(['status' => true, 'message' => 'Sign In']);
    }

    public function SignOut(Request $request)
    {
        $indianTime = Carbon::now('Asia/Kolkata');

        /**__ Get Time IN and Time Out value according to shift*/
        $shift = \DB::table('shifts')->where('id', auth()->guard('employee')->user()->shift)->first();

        $intless = intval($shift->less_hours);
        $updatedDateTime = $indianTime->subHours($intless);


        /**__ Sign out updated Time and Date__*/
        $updatedTime = $updatedDateTime->format('H:i:s');
        $updatedDate = $updatedDateTime->format('Y-m-d');

        $employee = Auth::guard('employee')->user();

        /** _____Get Last Entry of the attendance_____*/
        $is_exist = Attendence::where('employee_id', $employee->id)->where('date',  $updatedDate)->orderby('id', 'desc')->first();
        if ($is_exist) {
            Attendence::where('id',  $is_exist->id)->update(['time_out' => $updatedTime]);
            return redirect()->back()->with('success', 'Sign Out');
        }
        return redirect()->back()->with('error', 'You have not Signed in today');
    }

    public function EmployeeAttendence(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $id = $employee->id;
        if ($employee->shift == '3') {

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



            return view('employee.monthly_night', compact('monthlyDate', 'id'));
        } else {

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
            return view('employee.monthly', compact('monthlyDate', 'id'));
        }
    }


    public function EmployeeAttendenceHistory(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $id = $employee->id;
        $records = \DB::table('attendences')
            ->join('employees', 'attendences.employee_id', 'employees.id')
            ->select('employees.name', 'attendences.*')
            ->where('employees.id', $id)
            ->orderby('attendences.id', 'desc')
            ->paginate(10);
        $shift = \DB::table('shifts')->where('id', $employee->shift)->first();
        $intladd = intval($shift->less_hours);

        foreach ($records as $item) {

            if ($item->time_in) {
                $timeIn = Carbon::createFromFormat('H:i:s', $item->time_in);
                // Add two hours to the time
                $timeInWithTwoHoursAdded = $timeIn->addHours($intladd);
                // Format the resulting time as needed
                $item->time_in = $timeInWithTwoHoursAdded->format('H:i:s');
               
            }

            if ($item->time_out) {
                $timeOut = Carbon::createFromFormat('H:i:s', $item->time_out);
                $timeInWithTwoHourssubtract = $timeOut->addHours($intladd);
                $item->time_out = $timeInWithTwoHourssubtract->format('H:i:s');
            }



            $item->day = '';
            $item->time_in = $item->time_in ? Carbon::parse($item->time_in)->format('h:i A') : '';
            $item->time_out = $item->time_out ? Carbon::parse($item->time_out)->format('h:i A') : '';
            $item->date = $item->date ? Carbon::parse($item->date)->format('j F Y') : '';
            $item->day = $item->date ? Carbon::parse($item->date)->format('l') : '';

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
        return view('employee.attendence_records', compact('records', 'id'));
    }



    public function AttendenceCalendar(Request $request)
    {
        $indianTime = Carbon::now('Asia/Kolkata');
        $currentDate = $indianTime->format('Y-m-d');
        $employee = Auth::guard('employee')->user();
        $tasks = Attendence::where('employee_id', $employee->id)
            ->where('date', '<', $currentDate)
            ->get()
            ->unique('date');





        $leaves = \DB::table('leaves')->where('status', 'approved')->where('emp_id', $employee->id)->get();

        $dates_between = [];
        $Present = [];

        // foreach ($leaves as $leave) {
            
        //  $dates_between[] = ['attendence' => "leave", 'date' => $$leave->date];
        // }


        foreach ($tasks as $task) {
            $employee = \DB::table('employees')->where('id', $task->employee_id)->first();
            $shift = \DB::table('shifts')->where('id', $employee->shift)->first();
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

        return view('employee.attendence_calender', compact('combined_array'));
    }


    public function EmployeeAttendenceRecords(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $Date = $request->date;

        $records = \DB::table('attendences')
            ->select(\DB::raw("DATE_FORMAT(time_in, '%l:%i %p') as time_in"), \DB::raw("DATE_FORMAT(time_out, '%l:%i %p') as time_out"), 'time_in as formatted_in', 'time_out as formatted_out')
            ->where('employee_id', $employee->id)
            ->where('date', $Date)
            ->orderBy('id', 'asc')
            ->get();

        $shift = \DB::table('shifts')->where('id', $employee->shift)->first();

        $inttime = intval($shift->less_hours);

       

        foreach ($records as $record) {
            $timeIn = Carbon::createFromFormat('H:i:s', $record->formatted_in);
            $timeOut = Carbon::createFromFormat('H:i:s', $record->formatted_out);
    
            $formattedTime = $timeIn->addHours($inttime);
            $subformattedTime = $timeOut->addHours($inttime);
    
            $record->time_in = $formattedTime->format('H:i a');
            $record->time_out = $subformattedTime->format('H:i a');


            if ($record->time_in == null) {
                $record->time_in = '';
            }

            if ($record->time_out == null) {
                $record->time_out = '';
            }
        }
        return response()->json(['status' => true, 'Data' => $records]);
    }
}
