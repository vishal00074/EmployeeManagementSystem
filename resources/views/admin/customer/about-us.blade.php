@extends('admin.customer.extra.app')







@section('content')



 <!-- Content area  -->



<div class="content">



     <!-- Page length options  -->



    <div class="card">



        <div class="card-header header-elements-inline">



        	<div class="col-sm-6 mb-1" align="left">



			    <h6 class="card-title"><b>Add About Us</b></h6>



            </div> 



        	<div class="col-sm-6 mb-1" align="right">



				<button type="button" class="btn btn-success btn-sm">



					<a href="" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>



				</button>



			</div>



        </div>



        



         @if(session('success'))







            <div class="alert alert-success">







                {{ session('success') }}







            </div>



            @endif



        <div class="card-body"> 



            <form class="VendorDetails" name="VendorDetails" action="{{ url('/admin/addaboutus') }}" method="POST" enctype="multipart/form-data" >



                @csrf



                @method('POST')



                <div class="row">



                   <div class="col-md-6">



                       <div class="row">



                           <div class="col-md-12">



                                <div class="form-group">



                                    <label>Address</label>



                                    <input type="text" class="form-control" id="" placeholder="Address" class="form-control @error('address') is-invalid @enderror"  name="address">



                                    @if ($errors->has('address'))



                                    <span class="text-danger">{{ $errors->first('address') }}</span>



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



                                    <label>Phone</label>



                                    <input type="text" class="form-control" id="" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror"  name="phone">



                                    @if ($errors->has('phone'))



                                    <span class="text-danger">{{ $errors->first('phone') }}</span>



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



                                    <label>Email</label>



                                    <input type="email" class="form-control" id="" placeholder="Email" class="form-control @error('email') is-invalid @enderror"  name="email">



                                    @if ($errors->has('email'))



                                    <span class="text-danger">{{ $errors->first('email') }}</span>



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



                                    <label>About Us</label>



                                    <input type="text" class="form-control" id="" placeholder="About Us" class="form-control @error('about_us') is-invalid @enderror"  name="about_us">



                                    @if ($errors->has('about_us'))



                                    <span class="text-danger">{{ $errors->first('about_us') }}</span>



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



                                    <label>Terms & Condition</label>



                                    <input type="text" class="form-control" id="" placeholder="Terms & Condition" class="form-control @error('terms_condition') is-invalid @enderror"  name="terms_condition">



                                    @if ($errors->has('terms_condition'))



                                    <span class="text-danger">{{ $errors->first('terms_condition') }}</span>



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



                                    <label>Privacy Policy</label>



                                    <input type="text" class="form-control" id="" placeholder="Privacy Policy" class="form-control @error('privacy_policies') is-invalid @enderror"  name="privacy_policies">



                                    @if ($errors->has('privacy_policies'))



                                    <span class="text-danger">{{ $errors->first('privacy_policies') }}</span>



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



@endsection