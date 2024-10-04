@extends('admin.customer.app')



@section('content')
<div class="content">

    <!-- Page length options  -->

    <div class="card">

        <div class="card-header header-elements-inline">

            <div class="col-sm-6 mb-1" align="left">

                <!-- <h6 class="card-title"><b>Link</b></h6> -->

            </div>

        </div>



        <div class="card-body">

            <div class="row">



                <div class="col-md-6">

                    <form class="VendorDetails" action="{{ url('save_link')}}" method="POST">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="vendor_data" value="">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Android Application Link</label>

                                    <input type="text" class="form-control" name="android" value="{{ $applink->App_link }}">

                                </div>

                                <div class="form-group">
                                    <label>Ios Application Link</label>
                                    <input type="text" class="form-control" name="ios" value="{{ $applink->Ios_link }}">
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



@endsection