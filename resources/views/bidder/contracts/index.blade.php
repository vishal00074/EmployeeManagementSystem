@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Contracts Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
							<button type="submit" class="btn btn-info btn-sm">
								<a href="{{ url('employee/contract/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Contract</a>
							</button>
						</div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/bidder') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                     <table class="table get_Customer_details">
                        <thead>
                            <tr>
            
                                <th>Project Name</th>
                                <th>Client Name</th>
                                <th>Upwork Id</th>
                                <th>Department</th>
                                <!-- <th>Employee Name</th>  -->
                                <th>Assign BY</th>
                                <!-- <th>Assign Date</th> -->
                                <th>Project Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>

        </div>
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
            "order": [[ 0, "desc" ]],
            ajax: {
                url: "{{ url('employee/contracts') }}",
                },
            columns: [

                {data: 'project_name', name: 'Project Name'},
                {data: 'client_name', name: 'Client Name'},
                {data: 'upwork_id', name: 'Upwork Id'},
                {data: 'project_description', name: 'project_description'},
                {data: 'assign_by', name: 'Assign BY'},
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
                {data: 'Actions', name: 'Actions', orderable:false, searchable:false}
            ]
        });
        
        $('body').on('click', '.delete-customer', function () {
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
                if(result.value) {
                    $.ajax({
                        type:'Delete',
                        url:"{{ url('admin/project_delete') }}/"+id,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            swalInit.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            .then((willDelete) => {
                                location.reload();
                            });
                        },
                        error: function (response) {
                            swalInit.fire(
                                'Error deleting!',
                                'Please try again!',
                                'error'
                            )
                        }
                    });
                }
                else if (result.dismiss === swal.DismissReason.cancel) {
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