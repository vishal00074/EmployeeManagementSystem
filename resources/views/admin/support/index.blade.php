@extends('admin.support.app')

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
                  <!-- <a href="{{ url('admin/support/add') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Message</button></a> -->
               </h5>
            </div>
            <div class="col-md-7" align="right">
            </div>
        </div>
        
        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Subject</th>
                    <th>Description</th>
                     <th>Status</th>

                    <th>Change Status</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /page length options -->
</div>
@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

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
    scrollX: true,
    order: [[0, "desc"]],
    ajax: {
        url: "{{ url('admin/support') }}",
    },
    columns: [
        {data: 'employee_name', name: 'employee_name'},
        {data: 'subject', name: 'subject'},
        {data: 'description', name: 'description'},
        {data: 'status', name: 'status'},
        {
            data: 'id',
            name: 'Actions',
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                // Generate the HTML for the dropdown
                var dropdown = '<select class="form-control change-status" data-id="' + row.id + '">';
                var statusOptions = ['open', 'processing', 'closed'];
                statusOptions.forEach(function(option) {
                    dropdown += '<option value="' + option + '"';
                    if (option === row.status) {
                        dropdown += ' selected';
                    }
                    dropdown += '>' + option.charAt(0).toUpperCase() + option.slice(1) + '</option>';
                });
                dropdown += '</select>';
                
                // Generate the HTML for the Message button
                var messageButton = '<a href="{{ url('admin/support/add') }}?id=' + row.id + '&employee_name=' + encodeURIComponent(row.employee_name) + '" class="btn btn-primary btn-sm"><i class="icon-plus-circle2 mr-2"></i> Message</a>';

                // var messageViewButton = '<a href="{{ url('admin/support/view') }}?id=' + row.id + '&employee_name=' + encodeURIComponent(row.employee_name) + '" class="btn btn-primary btn-sm">View Detail</a>';


                // Combine dropdown and messageButton into one cell with a non-breaking space (&nbsp;) between them
                var actions = '<div class="btn-group" role="group">' + dropdown + '&nbsp;' + messageButton + '&nbsp;'  + '</div>';
                
                return actions;
            }
        }
    ]
});



        
        // Handle change status dropdown change event
        $('body').on('change', '.change-status', function () {
            var id = $(this).data('id');
            var status = $(this).val();
            $.ajax({
                type: 'PUT',
                url: '{{ url('admin/support/change-status') }}/' + id,
                data: {
                    status: status
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {


                    // Reload the DataTable
                    dataTable.ajax.reload();
                },
                error: function (response) {
                    console.log('Error occurred while changing status.');
                }
            });
        });




        
        // $('body').on('click', '.delete-customer', function () {
        //     var id = $(this).attr('data-id');
        //     swalInit.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes, delete it!',
        //         cancelButtonText: 'No, cancel!',
        //         confirmButtonClass: 'btn btn-success',
        //         cancelButtonClass: 'btn btn-danger',
        //         buttonsStyling: false
        //     }).then(function(result) {
        //         if(result.value) {
        //             $.ajax({
        //                 type:'Delete',
        //                 url:'{{ url('admin/shift_delete') }}/'+id,
        //                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //                 success: function (response) {
        //                     swalInit.fire(
        //                         'Deleted!',
        //                         'Your file has been deleted.',
        //                         'success'
        //                     )
        //                     .then((willDelete) => {
        //                         location.reload();
        //                     });
        //                 },
        //                 error: function (response) {
        //                     swalInit.fire(
        //                         'Error deleting!',
        //                         'Please try again!',
        //                         'error'
        //                     )
        //                 }
        //             });
        //         }
        //         else if (result.dismiss === swal.DismissReason.cancel) {
        //             swalInit.fire(
        //                 'Cancelled',
        //                 'Your imaginary file is safe.',
        //                 'error'
        //             )
        //         }
        //     });
        // });
    });
</script>
@endsection