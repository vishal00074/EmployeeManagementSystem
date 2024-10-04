@extends('admin.customer.app')

@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1">
                <h6 class="card-title"><b>Add Sliders</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <button type="button" class="btn btn-success btn-sm">
                    <a href="{{ url('/admin/intro_sliders')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form class="EditVendorDetails" name="EditVendorDetails" action="{{ url('/admin/intro_sliders/edit',$sliders->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Title</label>
                                    <input type="text" class="form-control" id="" class="form-control" name="image_title" value="{{$sliders->image_title}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Title Fr</label>
                                    <input type="text" class="form-control" id="" class="form-control" name="image_title_fr" value="{{$sliders->image_title_fr}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" class="form-control" id="" class="form-control" name="description">{{$sliders->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description Fr</label>
                                    <textarea type="text" class="form-control" id="" class="form-control" name="description_fr">{{$sliders->description_fr}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="" class="form-control" name="title" value="{{$sliders->title}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" id="" name="image">
                                </div>
                                <img src="{{$sliders->image}}" height="80px" width="90px" alt="no image">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="submit_form">Add Slider<i class="icon-paperplane ml-2"></i></button>
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
    $(document).ready(function() {
        if ($(".EditVendorDetails").length > 0) {
            $(".EditVendorDetails").validate({
                rules: {
                    title: "required",
                    image_title: "required",
                    image_title_fr: "required",
                    description: "required",
                    description_fr: "required"
                },
                messages: {
                    title: "Title field is required.",
                    image_title: "Image title field is required.",
                    image_title_fr: "Image Title Fr field is required.",
                    description: "Description field is required.",
                    description_fr: "Description Fr field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
@endsection