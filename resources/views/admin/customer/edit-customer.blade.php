@extends('admin.customer.app')

@section('content')
 <!-- Content area  -->
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1">
			    <h6 class="card-title"><b>Update Customer</b></h6>
            </div>
        	<div class="col-sm-6 mb-1" align="right">
				<button type="button" class="btn btn-success btn-sm">
					<a href="{{ url('/admin/customer')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
				</button>
			</div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <div class="card-body"> 
            <form class="VendorDetails" name="VendorDetails" action="{{ url('/admin/update_customer',$data->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="" placeholder="Name" class="form-control @error('title') is-invalid @enderror"  name="name" value="{{$data->name}}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" class="form-control @error('status') is-invalid @enderror"  name="status">
                                        <option>Select</option>
                                        <option value="0" {{ ($data->status == '0') ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ ($data->status == '1') ? 'selected' : '' }}>Inactive</option>
                                        <option value="2" {{ ($data->status == '2') ? 'selected' : '' }}>Suspended</option>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="" placeholder="Phone Number" class="form-control @error('phone_number') is-invalid @enderror"  name="phone_number" value="{{$data->phone_number}}">
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!--<div class="col-md-12">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>Email</label>-->
                            <!--        <input type="text" class="form-control" id="" placeholder="Email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{$data->email}}">-->
                            <!--        @if ($errors->has('email'))-->
                            <!--            <span class="text-danger">{{ $errors->first('email') }}</span>-->
                            <!--        @endif-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="submit_form">Update<i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <!-- /page length options  -->
</div>
@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        if ($(".VendorDetails").length > 0) {
            $(".VendorDetails").validate({
                rules: {
                    name: "required",
                    status: "required",
                    phone_number: "required"
                },
                messages: {
                    name: "Name field is required",
                    status: "Status field is required",
                    phone_number: "Phone number field is required"
                }
            });
        } 
    });
</script>
@endsection