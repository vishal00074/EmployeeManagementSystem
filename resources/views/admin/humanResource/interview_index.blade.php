@extends('admin.humanResource.app')

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
        <div class ="row s-filter">
            <div class="col-md-3">
               <h5 class="ml-2 mb-0">
                  <a href="{{ url('admin/humanResource/interview/add') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Add</button></a>
                   <a href="{{ url('admin/humanResource') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-minus-circle2 mr-2"></i> Back</button></a>
               </h5>
            </div>
            <div class="col-md-7" align="right">
                <!--<div class="form-group d-flex fr-stus">-->
                <!--    <label><b>Status : </b></label>-->
                <!--    <select id="Status" class="form-control" style="width: 250px">-->
                <!--        <option value="">All</option>-->
                <!--        <option value="0">Active</option>-->
                <!--        <option value="1">Inactive</option>-->
                <!--        <option value="2">Suspended</option>-->
                <!--    </select>           			-->
                <!--</div>-->
            </div>
        </div>
        
        <table class="table get_Customer_details table-bordered">
            <thead>
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
                url: "{{ url('admin/humanResource/interview') }}",
                data: function (d) {
                        d.Status = $('#Status').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
            columns: [

                {data: 'candidate_name', name: 'candidate_name'},
                {data: 'department_name', name: 'department_name'},
                {data: 'interviewer_name', name: 'interviewer_name'},
             

                {
            data: 'interview_date_time',
            name: 'interview_date_time',
            render: function(data, type, full, meta) {
                return new Date(data).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric', hour: 'numeric', minute: 'numeric',  hour12: true });
            }
        },
                {data: 'interview_status', name: 'interview_status'},
               

                {data: 'Actions', name: 'Actions', orderable:false, searchable:false}
            ]
        });
        
        $('#Status').on('change', function(e) {
            dataTable.draw();
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
                        url:'{{ url('admin/interview_delete') }}/'+id,
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