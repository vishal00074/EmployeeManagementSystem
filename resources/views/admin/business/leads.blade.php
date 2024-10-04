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
</style>

@endsection
@section('content')
<!-- Content area -->
<div class="content">


    <!-- Page length options -->
    <div class="card">



        <div class="row s-filter">
            <div class="col-md-5">
            </div>
            <div class="col-md-7" align="right">
                <a href="{{ url('admin/business') }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>
            </div>
        </div>


        <div class="row s-filter">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Employee Name:</strong> {{ $employee->name ?? '' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Number of Total Leads:</strong> {{ $totalleads_count ?? 0 }}
                            </li>

                            <li class="list-group-item">
                                <strong>Number of Total Leads Today:</strong> {{ $todaysleads_count ?? 0 }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>




        </div>

        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Agency Name</th>
                    <th>Upwork ID</th>
                    <th>Client Name</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /page length options -->
</div>
@endsection

@section('script')
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

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
                url: "{{ url('/admin/leads/view') }}/" + id,
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
                    orderable: false,
                    searchable: false
                }
            ]
        });


        $('body').on('click', '.feebback', function() {
            var id = $(this).attr('data-id');
            swalInit.fire({
                title: 'Feedback',
                html: `<input id="remark" type="text" class="form-control" placeholder="Remark" required>
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
                    var remark= $('#remark').val();
                    var status= $('#status').val();
                    $.ajax({
                        type: 'Delete',
                        url: "{{ url('admin/leads/feedback ') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            remark:remark,   
                            status:status,   
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