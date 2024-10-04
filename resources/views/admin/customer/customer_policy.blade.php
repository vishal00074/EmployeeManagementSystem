@extends('admin.customer.app')





@section('content')

 

<div class="content">

     <!-- Page length options  -->

    <div class="card">

        <div class="card-body"> 

            <div class="row">

                <div class="col-md-6">

                     <form class="PolicyDetails" action="{{url('/admin/policydata/'.$policy->id)}}" method="POST">

                        @csrf

                        <h4>Policy Details</h4>

                        <div class="row">

                            <input type="hidden" name="policy_data" value="{{$policy->id}}">
                            

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Description</label>

                                   <textarea class="form-control" id="description" name="description">{{$policy->description}}</textarea>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Description French</label>

                                   <textarea class="form-control" id="description" name="description_fr">{{$policy->description_fr}}</textarea>

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

    



@endsection



@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>



@endsection