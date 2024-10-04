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
            <!-- <a class="text-light interview-link" href="{{ url('employee/hr/attendance') }}">
                <i class="fa fa-angle-right"></i>Edit Attendance
            </a> -->

            <a class="text-light interview-link" href="{{ url('employee/hr/attendance/files') }}">
                <i class="fa fa-angle-right"></i>Attendance Records
            </a>

            <a class="text-light interview-link" href="{{ url('employee/hr/job') }}">
                <i class="fa fa-angle-right"></i>Job
            </a>
            <a class="text-light interview-link" href="{{ url('employee/hr/candidate') }}">
                <i class="fa fa-angle-right"></i>Candidate
            </a>
            <a class="text-light interview-link" href="{{ url('employee/hr/interview/') }}">
                <i class="fa fa-angle-right"></i>Interview Detail
            </a>
        </div>
    </div>
</div>




@endsection