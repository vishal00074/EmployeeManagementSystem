@extends('admin.customer.app')

@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>View Query </b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <button type="button" class="btn btn-success btn-sm">
                    <a href="{{ url('/admin/customer_query')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                </button>
            </div>
        </div>
        <div class="table-responsive table-invoice">
            <table class="table table-striped" id="dataTable">
                <tbody>

             
                    <tr>
                        <td>Customer  Id</td>
                        <td>{{$data->id}}</td>
                    </tr>
                    
                    <tr>
                        <td>Name</td>
                        <td>{{$data->name}}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>{{$data->email}}</td>
                    </tr>

                    <tr>
                        <td>Message</td>
                        <td>{{$data->message}}</td>
                    </tr>
                
                </tbody>
            </table>
        </div>
    </div>
    <!-- /page length options  -->
</div>
@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".UOMDetails").length > 0) {
            $(".UOMDetails").validate({
                rules: {
                    Description: "required",
                    UnitOfMeasurementSymbol: "required",
                    Status: "required"
                },
                messages: {
                    Description: "UOM Description field is required.",
                    UnitOfMeasurementSymbol: "Abbreviation field is required.",
                    Status: "Status field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
@endsection