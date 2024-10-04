@extends('admin.customer.app')

@section('content')
 <!-- Content area  -->
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Update Banner</b></h6>
            </div>
        	<div class="col-sm-6 mb-1" align="right">
				<button type="button" class="btn btn-success btn-sm">
					<a href="{{ url('/admin/banner_list')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
				</button>
			</div>
        </div>
        
         @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>
            @endif
    
        <div class="card-body"> 
            <form class="VendorDetails" name="VendorDetails" action="{{ url('/admin/update_banner',$banner->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('POST')
                <div class="row">
                   <div class="col-md-6">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="" placeholder="Name" class="form-control @error('title') is-invalid @enderror"  name="name" value="{{$banner->name}}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-6">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" id="image"  name="images" value="{{ $banner->images }}" >
                                  
                                    <img id="image_preview" src="{{ $banner->images }}"  width="100px" height="100px" alt="Image Preview" style="display: block;">
                                    @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="submit_form">Add Banner<i class="icon-paperplane ml-2"></i></button>
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
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">


$('#image').change(function() {
        var file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });


    $(document).ready(function(){
        if ($(".UOMDetails").length > 0) {
            $(".UOMDetails").validate({
                rules: {
                    Description : "required",
                    UnitOfMeasurementSymbol: "required",
                    Status: "required"
                },
                messages: {
                    Description : "UOM Description field is required.",
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