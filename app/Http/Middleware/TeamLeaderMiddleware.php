<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\TLTrait;

class TeamLeaderMiddleware
{
    use TLTrait;
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

        $is_exists = $this->TLModule($employeeID);
        if ($is_exists) {
            return $next($request);
        }
        return redirect('/emplpoyee')->with('error', 'You are unable to access  Team Leader module.');
    }
}
