@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>All Records</b></h4>
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-6 col-md-6 mb-4" align="left">
							<button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button>
						</div> -->
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table employee_attendance">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Employee Name</th>
                                <th>Sign IN</th>
                                <th>Sign Out</th>
                                <th>Date</th>
                                <th>Remark</th>
                                <th>IP Address</th>
                                <th>Total Hours</th>

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
        var dataTable = $('.employee_attendance').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            //pageLength: 5,
            scrollX: true,
            "order": [
                [0, "desc"]
            ],
            ajax: {
                url: "{{ url('employee/hr/attendence/records') }}/{{ $id }}",
                data: function(d) {
                    d.Status = $('#Status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'time_in',
                    name: 'time_in'
                },
                {
                    data: 'time_out',
                    name: 'time_out'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'remark',
                    name: 'remark'
                },
                {
                    data: 'ipaddress',
                    name: 'ipaddress'
                },
                {
                    data: 'total_hours',
                    name: 'total_hours'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                var timeIn = data.time_in_default;
                var timeOut = data.time_out_default;
                var a = data.time_in_default;
                var o = data.time_out_default;
                var b = '9:31:00';
                // if (timeIn !== null && typeof timeIn !== 'undefined') {

                //     var timeA = new Date();
                //     timeA.setHours(a.split(":")[0], a.split(":")[1], a.split(":")[2]);
                //     timeB = new Date();
                //     timeB.setHours(b.split(":")[0], b.split(":")[1], b.split(":")[2]);

                //     if (timeA > timeB) {
                //         $(row).css('background-color', '#FF6F61');
                //     } else if (timeIn < '9:31:00' && timeOut > '18:30:00') {
                //         $(row).css('background-color', 'lightgreen');
                //     }

                // }
            }
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