@extends('admin.customer.app')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class ="row s-filter">
            <div class="col-md-3">
               <h5 class="ml-2 mb-0">
                   <a href="{{url('/admin/banner')}}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Add</button></a>
               </h5>
            </div>
        </div>
        
        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
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
            //pageLength: 5,
            scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: "{{ url('/admin/banner_list') }}",
            columns: [
                {data: 'name', name: 'name'},
               {data: 'images', name: 'images',
                    render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"60\" alt='No Image'/>";
                    }
                },
                {data: 'Actions', name: 'Actions', orderable:false, searchable:false}
            ]
        });
    });
</script>
@endsection
<!-- ========== table components end ========== -->
