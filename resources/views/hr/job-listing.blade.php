@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Job Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
							<button type="submit" class="btn btn-info btn-sm">
								<a href="{{ url('employee/hr/job/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Job</a>
							</button>
						</div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/hr') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table job">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Job Title</th>
                                <th>Job Position</th>
                                <th>Job Skill</th>
                                <th>Job Budget</th>
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

        // Initialize DataTable with server-side processing
        var dataTable = $('.job').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,

            order: [
                [0, "desc"]
            ],
            ajax: {
                url: "{{ url('employee/hr/job') }}",
            },
            columns: [{
                    data: 'job_title',
                    name: 'Job Title'
                },
                {
                    data: 'job_position',
                    name: 'Job Position'
                },
                {
                    data: 'job_skill',
                    name: 'Job Skill'
                },
                {
                    data: 'job_budget',
                    name: 'Job Budget'
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false
                }
            ]
        });

        $(document).ready(function() {
            // Draw the table
            dataTable.draw();
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
                        url: "{{ url('employee/hr/delete_job ') }}/" + id,
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