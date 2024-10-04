@extends('employee.layouts.app')
@section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
     <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
   
   

@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Project Sheet</b></h4>
                    </div>
                </div>

                @php
                $is_teamLeader = TeamLeader();
                @endphp

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
							<!-- <button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button> -->
						</div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm table-bordered" id="data">
                    <table class="table get_projects">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Project Name</th>
                                <th>Client Name</th>
                                <th>Assign By</th>
                                <th>Assign Date</th>
                                <th>Department</th>
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

        // init datatable.
        var dataTable = $('.get_projects').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            //pageLength: 5,
            scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: {
                url: "{{ url('employee/projects') }}",
                },
            columns: [
                {data: 'project_name', name: 'project_name'},
                {data: 'client_name', name: 'client_name'},
                {data: 'assign_by_name', name: 'assign_by_name'},
                {data: 'assign_date', name: 'assign_date'},
                {data: 'department_name', name: 'department_name'},
                {data: 'project_status', name: 'project_status'},
              
                
                {data: 'Actions', name: 'Actions', orderable:false, searchable:false}
            ]
        });
        
        
       
    });
</script>
@endsection