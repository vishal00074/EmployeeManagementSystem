@extends('admin.project.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">



@endsection
@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-3">
                
            </div>
            <div class="col-md-7" align="right">
                <h5 class="ml-2 mb-0">
                    <a href="{{ url('admin/project/task-view/') }}/{{ $project->project_id }}"><button type="button" class="btn btn-primary">Back</button></a>
                </h5>
            </div>
        </div>

        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Subject</th>
                    <th>Billing Hours</th>
                    <th>Non billing hours</th>
                    <th>Message</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($taskreports as $report)
                <tr>
                    <td>{{ ucfirst($report->emp_name) }}</td>
                    <td>{{ ucfirst($report->subject) }}</td>
                    <td>{{ $report->task_billing_hours }}</td>
                    <td>{{ $report->task_non_billing_hours }}</td>
                    <td>{{ ucfirst($report->message) }}</td>
       
                    <td>@foreach($report->documents as $key => $singledoc)
                        <a href="{{ url($singledoc) }}" class="btn btn-success  btn-sm" target="_blank">Document</a>&nbsp;
                        @endforeach
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('script')
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>



@endsection