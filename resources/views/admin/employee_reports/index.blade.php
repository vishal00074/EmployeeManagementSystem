@extends('admin.employee_reports.app')
@section('css')
<style>
    .serv-box span {
        display: inline;
    }

    .serv-box img {
        width: 174px !important;
        height: 175px !important;
        object-fit: cover;
    }

    .dashboard .card {
        width: 100%;
    }

    .content-wrapper .card {
        padding: 20px 10px;
    }
</style>
@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-xl-12">
            <!-- Quick stats boxes -->
            <div class="row dashboard ml-5 mr-5 mt-4">
                @foreach($employees as $employee)
                <div class="col-sm-3 mt-4 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="serv-box text-center">
                                <a href="{{ url('admin/employee/report/detail') }}/{{ $employee->id  }}" class="text-dark" style="text-decoration: none; color: black;">
                                    @if($employee->photo != '')
                                    <img src="{{asset($employee->photo)}}" style="width: 100px; height: auto; display: block; margin: 0 auto;">
                                    @else
                                    <img src="{{asset('uploads/photo/1709374170.jpg')}}" style="width: 100px; height: auto; display: block; margin: 0 auto;">
                                    @endif
                                    <span style="display: block; margin-top: 10px; font-size: 14px;">{{ $employee->name ?? '' }}</span>
                                    <span style="color: green; font-size: 13px;">Completed Project: {{ $employee->complete_count ?? '' }}</span>&nbsp;
                                    <span style="color: #b3b30b; font-size: 13px;"> In Processing: {{ $employee->inprocessing_count ?? '' }}</span>
                                    <span style="display: block; color: red; font-size: 13px;">Pending: {{ $employee->pending_count ?? '' }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            <!-- /quick stats boxes -->
        </div>
    </div>
</div>


@endsection