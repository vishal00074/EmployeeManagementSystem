@extends('employee.layouts.app')



@section('content')
<div class="row table-box">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="content">
            <h3>HR Activity</h3>
            <h2></h2>

            <!--<a id="UploadAggrement">Upload Aggrement</a>-->
            <a class="text-light interview-link" href="{{ url('employee/hr/attendance') }}">
                <i class="fa fa-angle-right"></i>Edit Attendance
            </a>

            <a class="text-light interview-link" href="{{ url('employee/hr/attendance/file/records') }}">
                <i class="fa fa-angle-right"></i>Attendance Records
            </a>

            <a class="text-light interview-link" href="{{ url('employee/hr') }}">
                <i class="fa fa-angle-left"></i>Back
            </a>

        </div>
    </div>
</div>

@endsection