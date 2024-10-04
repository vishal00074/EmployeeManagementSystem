@extends('admin.business.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">



<style>
    .bidder-img {
        height: 10rem;
        width: 10rem;
        margin-right: 10px;

    }


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
        top: 21px;
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
        top: 21px;
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
<!-- Content area -->
<div class="content">

    <div class="card">
        <div class="row s-filter">
            <div class="col-md-5">
            </div>
            <div class="col-md-7" align="right">
                <a href="{{ url('admin/business') }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Employee Name</b></label>
                                <input type="text" class="form-control" value="{{ $employee->name }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Hired Contract:</b></label>
                                <input type="text" class="form-control" id="contractHired" value="{{ $contractHired }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Total Hired Contract:</b></label>
                                <input type="text" class="form-control" id="TotalcontractHired" value="{{ $TotalcontractHired }}" readonly>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Bids</b></label>
                                <input type="text" class="form-control" id="todaysbids_count" value=" {{ $todaysbids_count ?? 0 }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Total Bids:</b></label>
                                <input type="text" class="form-control" id="totalbids_count" value="{{ $totalbids_count }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Connects</b></label>
                                <input type="text" class="form-control" id="todaysconnects_count" value=" {{ $todaysconnects_count ?? 0 }}" readonly>

                            </div>
                        </div>


                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Total Connects Used</b></label>
                                <input type="text" class="form-control" id="totalconnects_count" value="{{ $totalconnects_count ?? 0 }}" readonly>

                            </div>
                        </div>



                      
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-8">
            </div>
            <div class="col-md-4" align="right">
                <strong>Date Filter:</strong>
                <input type="date" class="form-control" name="date" id="date" value="" />

            </div>
        </div>
        <table class="table get_Customer_details table-bordered">
            <thead>
                <tr>
                    <th>Agency Name</th>
                    <th>Upwork ID</th>
                    <th>Date</th>
                    <th>Connects</th>
                    <th>Status</th>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
                url: "{{ url('/admin/bids/view') }}/" + id,
                data: function(d) {
                    d.date = $('#date').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'agency_name',
                    name: 'agency_name'
                },
                {
                    data: 'upwork_name',
                    name: 'upwork_name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'connects',
                    name: 'connects'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    searchable: false
                }
            ],

        });

        $("#date").change(function() {
            dataTable.draw();
            var id = <? echo $id; ?>;
            var totalbids_count = $('#totalbids_count');
            var totalconnects_count = $('#totalconnects_count');
            var todaysbids_count = $('#todaysbids_count');
            var todaysconnects_count = $('#todaysconnects_count');
            var contractHired = $('#contractHired');
            var TotalcontractHired = $('#TotalcontractHired');
            
            $.ajax({
                url: "{{ route('bid.data.ajax') }}",
                type: 'GET',
                dataType: "json",
                data: {
                    date: $('#date').val(),
                    id: id,

                },
                success: function(response) {
                    data = response.data;
                    totalbids_count.val(data.totalbids_count);
                    totalconnects_count.val(data.totalconnects_count);
                    todaysbids_count.val(data.todaysbids_count);
                    todaysconnects_count.val(data.todaysconnects_count);
                    contractHired.val(data.contractHired);
                    TotalcontractHired.val(data.TotalcontractHired);
                    console.log(data);
                    console.log(data.totalbids_count);
                }
            });

        });


        $('body').on('click', '.feebback', function() {
            var id = $(this).attr('data-id');
            swalInit.fire({
                title: 'Feedback',
                html: `<input id="remark" type="text" class="form-control" placeholder="Remark" required><br>
            <select id="status" class="form-control" name="status">
             <option value="">Select</option>
             <option value="approved">Approved</option>
             <option value="disapprove">Disapprove</option>
             </select>`,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            }).then(function(result) {
                if (result.value) {
                    var remark = $('#remark').val();
                    var status = $('#status').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/bidder/feedback') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id,
                            remark: remark,
                            status: status,
                            type: "bids",
                        },
                        success: function(response) {
                            swalInit.fire(
                                    'Submitted!',
                                    'Your Feeback has been saved',
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