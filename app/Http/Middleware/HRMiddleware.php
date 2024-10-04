<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\HRTrait;
use App\Traits\AttendanceTrait;

class HRMiddleware
{
    use HRTrait, AttendanceTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $employeeID = auth()->guard('employee')->user()->id;

        $is_exists = $this->HrModule($employeeID);
        if ($is_exists) {
            return $next($request);
        }
        return redirect('/emplpoyee')->with('error', 'You are unable to access the HR module.');
        
    }
}
