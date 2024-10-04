<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
trait BidderTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function BidderModule($employeeID)
    {
        $role = \DB::table('rules')->where('employee_id', $employeeID)->orderby('id', 'desc')->first();

            if (isset($role)) {
                if ($role->type == 'BM') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
    }


    
}
