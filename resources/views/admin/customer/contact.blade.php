@extends('admin.customer.extra.app')





@section('content')

<div class="content">

     <!-- Page length options  -->

    <div class="card">

        <div class="card-body"> 

            <div class="row">

              <div class="col-md-6">

                     <form class="updatecontact" name="updatecontact" action="{{ url('admin/update/address') }}" method="POST">

                        @csrf

                        <h4>Contact Us</h4>

                        <div class="row">

                            <input type="hidden" name="id" value="{{ $data->id }}">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Address</label>

                                   <textarea class="form-control" id="address" name="address" value="{{ $data->address }}">{{ $data->address }}</textarea>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Phone Number</label>

                                   <input type="text" class="form-control" id="phone" name="phone"  value="{{ $data->phone }}">

                                </div>

                            </div>

                            <div class="col-md-12">

                            <div class="form-group">

                                <label>Email</label>

                            <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}">

                            </div>

                            </div>



                        </div>

                        

                        <div class="row">

                            <div class="col-md-12">

                                <div class="text-center">

                                    <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>

                                  

                                </div>

                            </div>

                        </div>

                        

                    </form>

                    </div>


                </div>

              

            </div>

        </div>

    </div>

</div>





@endsection

@section('script')

<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        if ($(".updatecontact").length > 0) {

            $(".updatecontact").validate({

                rules: {

                    address: "required",

                    phone: "required",

                    email: "required",

                },

                messages: {

                    address: "address field is required.",

                    phone: "phone number field is required.",

                    email: "email  field is required.",


                },

                submitHandler: function(form) {

                    form.submit();

                }

            });

        }

    });

</script>

@endsection