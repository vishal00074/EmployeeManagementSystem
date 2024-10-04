@extends('employee.layouts.app')
@section('css')
<style>
     .feebback:hover .popup {
        opacity: 1;
        display: block;
    }

    .popup {
        max-width: 20rem;
        margin: -30px 10px 10px -254px;
        background-color: rgba(180, 180, 200);
        padding: 43px 34px;
        position: absolute;
        top: -1px;
        transition: all 0.25s ease;
        opacity: 0;
        display: none;
        z-index: 9;
    }

    .dataTables_scroll .dataTables_scrollBody td,
    .dataTables_scroll .dataTables_scrollBody th,
    .dataTables_scrollBody th p,
    .dataTables_scrollBody th strong {
        white-space: normal !important;
    }

    .popup strong,
    .popup p {
        white-space: normal !important;
    }

    .popup {
        margin: -30px 10px 10px -254px;
        background-color: rgb(59 52 145);
        position: absolute;
        top: -1px;
        transition: all 0.25s ease;
        opacity: 0;
        display: none;
        z-index: 9;
        left: 67%;
        width: 153px;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Bids Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <button type="submit" class="btn btn-info btn-sm">
                            <a href="{{ url('employee/bid/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Bid</a>
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
                                <th>Used Connects</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Approval Status</th>
                                <th>Url</th>
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
                url: "{{ url('employee/bids') }}",
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
                    data: 'connects',
                    name: 'connects'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'FeedbackStatus',
                    name: 'FeedbackStatus',
                    orderable: false
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                if (data.feedback_status === 'approved') {
                    $('td', row).addClass('bg-success');
                } else if (data.feedback_status === 'disapprove') {
                    $('td', row).addClass('bg-secondary');
                } else {
                    
                }
            }
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
                        url: "{{ url('employee/bid/delete_bid') }}/" + id,
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