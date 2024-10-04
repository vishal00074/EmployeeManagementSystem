@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Interview Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <button type="submit" class="btn btn-info btn-sm">
                            <a href="{{ url('employee/hr/interview/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Interview</a>
                        </button>
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/hr') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table interview">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Candidate Name</th>
                                <th>Department</th>
                                <th>Interviewer Name</th>
                                <th>Interview Date Time</th>
                                <th>interview Status</th>

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
        var dataTable = $('.interview').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            //pageLength: 5,
            scrollX: true,
            "order": [
                [0, "desc"]
            ],
            ajax: {
                url: "{{ url('employee/hr/interview') }}",
                data: function(d) {
                    d.Status = $('#Status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [

                {
                    data: 'candidate_name',
                    name: 'candidate_name'
                },
                {
                    data: 'department_name',
                    name: 'department_name'
                },
                {
                    data: 'interviewer_name',
                    name: 'interviewer_name'
                },


                {
                    data: 'interview_date_time',
                    name: 'interview_date_time',
                    render: function(data, type, full, meta) {
                        return new Date(data).toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        });
                    }
                },
                {
                    data: 'interview_status',
                    name: 'interview_status'
                },


                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#Status').on('change', function(e) {
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
                        url: "{{ url('hr/interview_delete') }}/" + id,
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