@extends('admin.customer.extra.app')





@section('content')

 

<div class="content">

     <!-- Page length options  -->

    <div class="card">

        <div class="card-body"> 

            <div class="row">

              <div class="col-md-6">

                     <form class="AboutDetails" action="{{ url('/admin/aboutus',$about->id)}}" method="POST">

                        @csrf

                        <h4>About Us Details</h4>

                        <div class="row">

                            <input type="hidden" name="about_data" value="{{$about->id}}">

                            <div class="col-md-12">

                                 <div class="form-group">

                                <label>Description</label>

                                <textarea class="form-control" id="description" name="description">{{$about->description}}</textarea>

                            </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Email</label>

                                    <input type="text" class="form-control" name="email" value="{{$about->email}}"> 

                                </div>

                            </div>

                        </div>

                        

                          <div class="row">

                            <div class="col-md-12">

                                 <div class="form-group">

                                <label>Address</label>

                               <textarea class="form-control" id="address" name="address">{{$about->address}}</textarea>

                            </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Details</label>

                                    <textarea class="form-control" id="aboutdescription" name="aboutdescription">{{$about->aboutdescription}}</textarea>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Discription French</label>

                                    <textarea class="form-control" id="discription_fr" name="discription_fr">{{$about->discription_fr}}</textarea>

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

                    </form>

                </div>

              

            </div>

        </div>

    </div>

</div>



@endsection



@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>





  <script>

        ClassicEditor

            .create( document.querySelector( '#description' ) )

            .catch( error => {

                console.error( error );

            } );

    </script>



@endsection