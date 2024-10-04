<?php

namespace App\Traits;

use Illuminate\Http\Request;
trait TLTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function TLModule($employeeID)
    {
        $role = \DB::table('rules')->where('employee_id', $employeeID)->orderby('id', 'desc')->first();

            if (isset($role)) {
                if ($role->type == 'TL') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
    }


    
}
