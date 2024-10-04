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
                <h5 class="ml-2 mb-0">
                    <a href="{{ url('admin/project/task/add') }}/{{ $id }}"><button type="button" class="btn btn-primary btn-sm"><i class="icon-plus-circle2 mr-2"></i> Add</button></a>
                </h5>
            </div>
            <div class="col-md-7" align="right">
                <h5 class="ml-2 mb-0">
                    <a href="{{ url('admin/project') }}"><button type="button" class="btn btn-primary">Back</button></a>
                </h5>
            </div>
        </div>

        <table class="table-responsive get_Customer_details table-bordered">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Billing Hours</th>
                    <th>Non Billing Hours</th>
                    <th>Date</th>
                    <th>Document</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                <tr>
                    <td>
                        @if ($task->employee_id)
                        {{ $task->employeeName->name }}
                        @endif
                    </td>
                    <td>{{ ucfirst($task->title) }}</td>
                    <td>{{ ucfirst($task->description) }}</td>
                    <td>{{ $task->billing_hours }}</td>
                    <td>{{ $task->non_billing_hours }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->created_at)->isoFormat('D MMMM YYYY (h:mm:ss A)') }}</td>

                    <td>
                        @foreach($task->documents_path as $key => $singledoc)
                        <a href="{{ url($singledoc) }}" class="btn btn-success  btn-sm" target="_blank">Document</a>&nbsp;
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ url('admin/task/edit') }}/{{  $task->id }}" class="btn btn-warning btn-sm" style="margin-right: 5px;">Edit</a>
                        <a href="{{ url('admin/task/reports') }}/{{  $task->id }}" class="btn btn-info btn-sm">Report</a>
                        <a href="javascript:void({{ $task->id }})" data-id="{{  $task->id }}" class="delete-customer btn btn-sm btn-danger">Delete</a>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('body').on('click', '.delete-customer', function() {
            var id = $(this).attr('data-id');
            swalInit.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'Delete',
                        url: "{{ url('admin/task/delete') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swalInit.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                .then((willDelete) => {
                                    location.reload();
                                });
                        },
                        error: function(response) {
                            swalInit.fire(
                                'Error deleting!',
                                'Please try again!',
                                'error'
                            )
                        }
                    });
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalInit.fire(
                        'Cancelled',
                        'Your imaginary file is safe.',
                        'error'
                    )
                }
            });
        });
    });
</script>

@endsection