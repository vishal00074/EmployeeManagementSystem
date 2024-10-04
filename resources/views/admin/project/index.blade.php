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
                    <a href="{{ url('admin/project/add') }}"><button type="button" class="btn btn-primary btn-sm"><i class="icon-plus-circle2 mr-2"></i> Add</button></a>
                </h5>
            </div>
            <div class="col-md-7" align="right">
            </div>
        </div>

        <table class="table get_Customer_details table-bordered">
            <thead>
                <tr>
                    <th>Sr. no</th>
                    <th>Project Name</th>
                    <th>Client Name</th>
                    <th>Upwork Id</th>
                    <th>Department</th>
                    <th>Project Type</th>
                    <th>Project Amount</th>
                    <th>Assign BY</th>
                    <th>Project Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
@endsection

@section('script')
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
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
                url: "{{ url('admin/project') }}",
            },
            columns: [
                
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                   orderable: false, searchable: false
                },

                {
                    data: 'project_name',
                    name: 'Project Name'
                },
                {
                    data: 'client_name',
                    name: 'Client Name'
                },
                {
                    data: 'upwork_id',
                    name: 'Upwork Id'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                {
                    data: 'project_type',
                    name: 'project_type'
                },
                {
                    data: 'project_type',
                    render: function(data, type, row) {
                        if (data == 'Fixed') {
                            return row.fixed_total_amount;
                        } else if (data == 'Billing') {
                            return  '<p>'+ row.billing_per_hour_price +' Per Hour</p>';
                        } else {
                            return '<p>Not Found </p>';
                        }

                    }
                },
                {
                    data: 'assign_by',
                    name: 'Assign BY'
                },
                {
                    data: 'project_status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        var color = ''; // Initialize color variable

                        // Set background color based on project_status value
                        switch (data) {
                            case 'Pending':
                                color = 'red'; // Set background color to red
                                break;
                            case 'In-Processing':
                                color = '#8f930d'; // Set background color to red
                                break;
                            case 'Completed':
                                color = 'green'; // Set background color to green
                                break;
                            default:
                                // Handle any other cases or values if needed
                                break;
                        }

                        // Return the formatted HTML with background color
                        return '<div style="color: ' + color + '">' + data + '</div>';
                    }
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
                        url: "{{ url('admin/project_delete ') }}/" + id,
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