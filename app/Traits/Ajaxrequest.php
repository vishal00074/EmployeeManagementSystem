<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
trait Ajaxrequest
{
    public function Agency($agency_id)
    {
        $data = \DB::table('upworks')->where('agency_id', $agency_id)->get();
        return $data;
    } 
}