@extends('admin.leave.app')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
@endsection

@section('content')
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
         
            <div class="col-md-7" align="left">
               <b> {{ $leaves[0]->employee_name ?? '' }}</b>
            </div>
            <div class="col-md-3" align="right">
                <a href="{{ url('admin/leave/assign/history') }}" class="btn btn-success">Back</a>

            </div>

            <table class="table get_Customer_details">
                <thead>
                    <tr>
                        <th>Leave type</th>
                        <th>Assigned Leave</th>
                        <th>Used Leave</th>
                        <th>Total Leave</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaves as $leave)
                    <tr>
                        <td>{{ $leave->leave_name ?? '' }}</td>
                        <td>{{ $leave->days ?? '' }}</td>
                        <td>{{ $leave->used_leave ?? '' }}</td>
                        <td>{{ $leave->total_leave ?? '' }}</td>
                        <td>{{ $leave->start_date ?? '' }}</td>
                        <td>{{ $leave->end_date ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $leaves->links() !!}
            </div>
        </div>
        <!-- /page length options -->
    </div>

    @endsection


    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    @endsection