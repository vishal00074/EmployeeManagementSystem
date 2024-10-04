@extends('admin.attendence.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">



@endsection
@section('content')

@php
$totalcount = DB::table('night_attendences')
->where('employee_id', $id)
->select('time_in', 'time_out')
->whereMonth('time_out', Carbon\Carbon::now('Asia/Kolkata')->month)
->count();
@endphp
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-3">
                <h5 class="ml-2 mb-0">
                    <!-- <a href="{{ url('admin/department/add') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Add</button></a> -->
                    <b>Present: {{ $totalcount }} days</b>
                </h5>
            </div>
            <div class="col-md-7" align="right">
                <!--<div class="form-group d-flex fr-stus">-->
                <!--    <label><b>Status : </b></label>-->
                <!--    <select id="Status" class="form-control" style="width: 250px">-->
                <!--        <option value="">All</option>-->
                <!--        <option value="0">Active</option>-->
                <!--        <option value="1">Inactive</option>-->
                <!--        <option value="2">Suspended</option>-->
                <!--    </select>           			-->
                <!--</div>-->
                <a href="{{ url('admin/attendence/night') }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>
            </div>
        </div>

        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sign IN</th>
                    <th>Sign Out</th>
                    <th>Total Hours</th>
                </tr>
            </thead>

            <body>
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
            </body>
        </table>
    </div>
    <!-- /page length options -->
</div>
@endsection