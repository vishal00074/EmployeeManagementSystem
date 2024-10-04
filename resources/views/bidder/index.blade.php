@extends('employee.layouts.app')



@section('content')
<div class="row table-box">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="content">
            <h3>Bidder Activity</h3>
            <h2></h2>

            <!--<a id="UploadAggrement">Upload Aggrement</a>-->
            <a class="text-light interview-link" href="{{ url('employee/bids') }}">
                <i class="fa fa-angle-right"></i>My Bids
            </a>
            <a class="text-light interview-link" href="{{ url('employee/leads') }}">
                <i class="fa fa-angle-right"></i>My Lead
            </a>
            
            <a class="text-light interview-link" href="{{ url('employee/contracts') }}">
                <i class="fa fa-angle-right"></i>My Contract
            </a>
        </div>
    </div>
</div>




@endsection