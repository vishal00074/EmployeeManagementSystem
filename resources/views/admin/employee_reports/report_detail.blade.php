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
                <a href="{{ url('admin/employee/reports') }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>
            </div>
        </div>

        <div class="row s-filter">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <strong>Completed projects:</strong> {{ $employee->complete_count ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Project In Processing:</strong> {{$employee->inprocessing_count ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Pending Project:</strong> {{ $employee->pending_count ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Total Project:</strong> {{ $employee->total_project ?? ''  }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Assigned Task:</strong> {{ $employee->assigned_project_task ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Employee Total Billing Hours:</strong> {{ $employee->total_billing_hours ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Total Submitted Task:</strong> {{ $employee->total_non_billing_hours ?? '' }}
                            </li>
                            <li class="list-group-item">
                               
                            </li>

                        </ul>
                    </div>
                </div>
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
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /page length options -->
</div>
@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var id = <?php echo $id ?>;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // init datatable.
        var dataTable = $('.get_Customer_details').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            //pageLength: 5,
            scrollX: true,
            "order": [
                [0, "desc"]
            ],
            ajax: {
                url: "{{ url('admin/employee/report/detail') }}/" + id,
            },
            columns: [{
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'billing_hours',
                    name: 'billing_hours'
                },
                {
                    data: 'non_billing_hours',
                    name: 'non_billing_hours'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });


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
                        url: "{{ url('admin/department_delete ') }}/" + id,
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