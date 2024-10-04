@extends('admin.employee_reports.app')



@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-5">
                <H6>{{ $employee->name ?? '' }}</H6>
            </div>
            <div class="col-md-7" align="right">
                <a href="{{ url('admin/employee/report/detail') }}/{{ $project_task->employee_id }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>
            </div>
        </div>


        <div class="row s-filter">
            <div class="col-md-6">
                <b>Assigned Task List</b>
            </div>
        </div>

        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Billing Hours</th>
                    <th>Non Billing Hours</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <td>{{ $item->subject }}</td>
                <td>{{ $item->task_billing_hours }}</td>
                <td>{{ $item->task_non_billing_hours }}</td>
                <td>{{ $item->message }}</td>
                <td>@foreach($item->documents as $single_doc)
                    <a href="{{ asset($single_doc) }}" target="_blank" class="btn btn-success">view</a>
                    @endforeach
                </td>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>


@endsection