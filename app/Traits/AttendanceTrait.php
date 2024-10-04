<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
trait AttendanceTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function AttendanceStatus($first_signIN,  $last_signOut, $shift)
    {
        
        /**___ Add Hours for short Leave and Half day __*/

        $timeIn = Carbon::createFromFormat('H:i:s', $shift->time_in);
        $timeOut = Carbon::createFromFormat('H:i:s', $shift->time_out);
        
        // Add two hours to the time
        $timeInWithTwoHoursAdded = $timeIn->addHours(2);
        $timeInWithTwoHourssubtract = $timeOut->subHours(2);

        // Format the resulting time as needed
        $formattedTime = $timeInWithTwoHoursAdded->format('H:i:s');
        $subformattedTime = $timeInWithTwoHourssubtract->format('H:i:s');



        //Leaves

        $leave = \DB::table('leaves')
        ->join('leave_types', 'leaves.leave_type', 'leave_types.id')
        ->select('leave_types.name')
        ->where('leaves.emp_id', $first_signIN->employee_id)
        ->whereDate('leaves.date', $first_signIN->date)
        ->where('leaves.status', 'approved') 
        ->first();
       

        $active_status = '';
        if ($first_signIN->time_in <=   $shift->time_in  &&  $last_signOut->time_out >= $shift->time_out) {
            $active_status = 'Present';
        } elseif ($first_signIN->time_in >= $shift->time_in && $first_signIN->time_in <= $formattedTime) {
            $active_status = 'Penalty';
        } elseif ($first_signIN->time_in <= $shift->time_in  && $last_signOut->time_out <= $shift->time_out && $last_signOut->time_out >= $subformattedTime) {
            $active_status = 'Penalty';
        }  else {
            $active_status = 'Half Day';
        }

        if ($last_signOut->time_out == '') {
            $active_status = 'Half Day';
        }

        if( $leave != null){
            $active_status = $leave->name.' '.$first_signIN->time_in .' '.$last_signOut->time_out;
         
        }

        return  $active_status;
    }


    
}
