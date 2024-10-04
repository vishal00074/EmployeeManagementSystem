<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\{BidderTrait, Ajaxrequest};
use Session;
class BusinessMiddleware
{
    use BidderTrait, Ajaxrequest;
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

        $is_exists = $this->BidderModule($employeeID);
        if ($is_exists) {
            return $next($request);
        }
        Session::flash('error', 'You are unable to access the bidder module.');
        return redirect()->to('employee/');
        
    }
}
