@extends('admin.customer.extra.app')


@section('content')

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

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
					<a href="{{ url('/admin/slides_list')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
				</button>
			</div>
        </div>
        
         @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>
            @endif
    
        <div class="card-body"> 
            <form class="VendorDetails" name="VendorDetails" action="{{ url('/admin/update_privacy',$privacy->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('POST')
                <div class="row">
                   <div class="col-md-6">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="" placeholder="Name" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{$privacy->title}}">
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
                                    <input type="file" class="form-control" id=""  name="image" >
                                    <img src="{{$privacy->image}}" width="100px">
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
                   <div class="col-md-6">
                       <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10">{{$privacy->description}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
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
                            <button type="submit" class="btn btn-primary" id="submit_form">Add Now<i class="icon-paperplane ml-2"></i></button>
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
  <script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection