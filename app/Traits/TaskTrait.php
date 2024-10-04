<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
trait TaskTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function AssignTask(Request $request, $id)
    {
        return true;
    }


    
}
