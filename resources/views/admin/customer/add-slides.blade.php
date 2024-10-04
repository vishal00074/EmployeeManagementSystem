@extends('admin.customer.app')

@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1">
                <h6 class="card-title"><b>Add slides</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <button type="button" class="btn btn-success btn-sm">
                    <a href="{{ url('/admin/slides_list')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form class="VendorDetails" name="VendorDetails" action="{{ url('/admin/add_slides') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="" placeholder="title" class="form-control @error('title') is-invalid @enderror" name="title">
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
                                    <input type="file" class="form-control" id="" name="image">
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
                                    <label for="Brand">Brand</label>
                                    <select name="brand_id" onchange="brand_id(this.value)" class="status form-control" data-id="100184">
                                        <option selected value="">Select</option>
                                        @foreach($brand as $brands)
                                        <option value="{{$brands->id}}" aria-placeholder="brand">{{$brands->BrandName}}</option>
                                        @endforeach
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
                                    <label for="">Category</label>
                                    <select name="category_id" id="category" class="status form-control" data-id="100184" required>
                                        <option selected value="">Select</option>

                                        @foreach($category as $categories)
                                        <option value="{{$categories->id}}">{{$categories->CategoryName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Sub_Category</label>
                                    <select name="sub_category" id="sub-category" onchange="sub_category(this.value)" class="status form-control" data-id="100184">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Sub Sub Category</label>
                                    <select name="sub_sub_category" id="sub_sub_category" onchange="sub_sub_category(this.value)" class="status form-control" data-id="100184">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="submit_form">Add Slide<i class="icon-paperplane ml-2"></i></button>
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

<script>
    $(document).ready(function() {

        /*------------------------------------------
        --------------------------------------------
        Country Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#category').on('change', function() {
            var idCountry = this.value;
            $("#sub-category").html('');
            $.ajax({
                url: "{{url('admin/sub_category')}}",
                type: "POST",
                data: {
                    Category_Id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#sub-category').html('<option value="">-- sub-category --</option>');
                    $.each(result.states, function(key, value) {
                        $("#sub-category").append('<option value="' + value
                            .id + '">' + value.SubCategoryName + '</option>');
                    });
                    $('#sub_sub_category').html('<option value="">-- sub_sub_category --</option>');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        State Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#sub-category').on('change', function() {
            var idState = this.value;
            $("#sub_sub_category").html('');
            $.ajax({
                url: "{{url('admin/sub_sub_category')}}",
                type: "POST",
                data: {
                    Sub_Category_Id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#sub_sub_category').html('<option value="">-- sub_sub_category --</option>');
                    $.each(res.cities, function(key, value) {
                        $("#sub_sub_category").append('<option value="' + value
                            .id + '">' + value.SubCategoryName + '</option>');
                    });
                }
            });
        });

    });
</script>

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