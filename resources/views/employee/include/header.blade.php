<?php

use Carbon\Carbon;


$indianTime = Carbon::now('Asia/Kolkata');

$shift = \DB::table('shifts')->where('id', auth()->guard('employee')->user()->shift)->first();

$intless = intval($shift->less_hours);
$updatedDateTime = $indianTime->subHours($intless);


/**__ Sign IN updated Time and Date__*/
$updatedTime = $updatedDateTime->format('H:i:s');
$updatedDate = $updatedDateTime->format('Y-m-d');

$employee_status = DB::table('attendences')
	->where('employee_id', auth()->guard('employee')->user()->id)
	->where('date', $updatedDate)
	->orderby('id', 'desc')
	->first();

$hours = '';
?>
<section class="top_bar">
	<div class="container-fluid">
		<div class="row">
			<b> &nbsp; &nbsp; &nbsp;{{ auth()->guard('employee')->user()->name }}</b>
			<div class="col-sm-12 col-md-3 text-center">
				@if($employee_status==null || $employee_status->time_out !='')
				<div class="btn btn-primary btn-sm sing-in">Sign in
				</div>
				@else
				<a href="{{ url('employee/sign-out') }}" class="btn btn-danger btn-sm">Sign out
				</a>
				@endif
			</div>

			<div class="col-sm-12 col-md-3">
				<p>Sign IN: {{ isset($employee_status->time_in) ? \Carbon\Carbon::parse($employee_status->time_in)->addHours($intless)->format('h:i A') : '' }}</p>
				
				<p>Sign Out: {{ isset($employee_status->time_out) ? \Carbon\Carbon::parse($employee_status->time_out)->addHours($intless)->format('h:i A') : '' }} </p>
			</div>
		

			<div class="col-sm-1 text-center"><a href="{{ url('/employee/') }}"><i class="fa fa-home"></i> Home</a></div>
			<div class="col-sm-1 text-center"><b>Time<p id="clock"></p></b></div>
			<div class="col-sm-2 text-right"><a href="{{ url('/employee/logout') }}">
					<i class="fa fa-sign-out"></i> Logout
				</a></div>
			<div class="col-sm-2 text-right d-none d-sm-block d-md-none"><a class="menu-btn"> <i class="fa fa-bars"></i></a> </div>
		</div>
	</div>
</section>