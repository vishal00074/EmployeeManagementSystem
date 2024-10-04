<?php


 
function TeamLeader()
{
    $employeeID = auth()->guard('employee')->user()->id;

    $Is_teamLeader = \DB::table('rules')->where('employee_id', $employeeID)->orderby('id', 'desc')->first();

            if (isset($Is_teamLeader)) {
                if ($Is_teamLeader->type == 'TL') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
}



