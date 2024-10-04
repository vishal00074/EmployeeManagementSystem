@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Leads Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <button type="submit" class="btn btn-info btn-sm">
                            <a href="{{ url('employee/lead/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Lead</a>
                        </button>
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/bidder') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <select name="searchdate" id="searchdate" class="form-control searchdate">
                            <option value="">Select</option>
                            <option value="Today">Today</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="All">All</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table job">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Agency</th>
                                <th>Upwork</th>
                                <th>Client Name</th>
                                <th>Remakrs</th>
                                <th>Status</th>
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
                url: "{{ url('employee/leads') }}",
                data: function(d) {
                    d.searchdate = $('#searchdate').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'agnecy_name',
                    name: 'agnecy_name'
                },
                {
                    data: 'upwork_name',
                    name: 'upwork_name'
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false
                }
            ]
        });

        $('#searchdate').change(function() {
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
                        url: "{{ url('employee/lead/delete_bid') }}/" + id,
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