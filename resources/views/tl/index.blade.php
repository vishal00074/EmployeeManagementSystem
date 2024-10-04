@extends('employee.layouts.app')

@section('content')


<div class="row table-box">
        <div class="col-md-4">
            <br><br><br>
            
        </div>
        <div class="col-md-4">
            <div class="content">
                <h3>Team Leader Activity</h3>
               
                <a class="text-light interview-link" href="{{ url('employee/team/leave') }}">
                    <i class="fa fa-angle-right"></i>Team Member Leaves @if($totalleave_count > 0)<span class="count">{{ $totalleave_count ?? 0 }}</span> @endif
                </a>

            </div>
        </div>
    
    </div>


@endsection