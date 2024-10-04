@extends('employee.layouts.app')
@section('content')

@php
$totalcount = DB::table('night_attendences')
->where('employee_id', $id)
->select('time_in', 'time_out')
->whereMonth('time_out', Carbon\Carbon::now('Asia/Kolkata')->month)
->count();
@endphp
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Monthly Attendence Sheet</b></h4>
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-6 col-md-6 mb-4" align="left">
							<button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button>
						</div> -->
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Date</th>
                                <th>Sign IN</th>
                                <th>Sign Out</th>
                                <th>Total Hours</th>

                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">


                            @foreach($monthlyDate as $date)
                            @php
                            $attendence = DB::table('night_attendences')
                            ->where('employee_id', $id)
                            ->select('time_in', 'time_out')
                            ->whereDate('time_out', $date['date'])
                            ->first();

                            if ($attendence) {
                            $attendence->total_hours = '';
                            if ($attendence->time_in && $attendence->time_out) {
                            $attendence->total_hours = \Carbon\Carbon::parse($attendence->time_in)->diffInHours(\Carbon\Carbon::parse($attendence->time_out));
                            }
                            }
                            $rowColor = '';

                            // Set row color based on conditions
                            if (\Carbon\Carbon::parse($date['date'])->format('l') == 'Sunday') {
                            $rowColor = '#3CB371';
                            } elseif (\Carbon\Carbon::parse($date['date'])->format('l') == 'Saturday') {
                            $rowColor = 'yellow';
                            } elseif (!$attendence) {
                            $rowColor = '#ff4242'; // Medium red
                            }
                            @endphp
                            <tr style="background-color: {{ $rowColor }}">
                                <td>{{ isset($date['date']) ? \Carbon\Carbon::parse($date['date'])->format('j F Y') : '' }}</td>
                                <td>{{ isset($attendence->time_in) ? \Carbon\Carbon::parse($attendence->time_in)->format('j F Y h:i A') : '' }}</td>
                                <td>{{ isset($attendence->time_out) ? \Carbon\Carbon::parse($attendence->time_out)->format('j F Y h:i A') : '' }}</td>
                                <td>{{ $attendence->total_hours ?? '' }}</td>
                            </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection