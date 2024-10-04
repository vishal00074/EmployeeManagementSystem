@extends('admin.customer.extra.app')


@section('content')
 <!-- Content area  -->
<div class="content-page">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Edit Details</h4>
            </div>
        </div>
 
            <div class="container pt-3">
                 <div class="row edit-head">
                            <div class="col-6">
                                <!--<h4>Edit</h4>-->
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
            </div>
              <form action="{{ url('admin/bloglist/update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            
                           <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control" id="title" name ="title" value="{{$data->title}}"/>
                            </div>
                             
                           
                           
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" class="form-control" id="description" name ="description" value="{{$data->description}}"/>
                            </div>
                           
                           
                             
                         <div class="form-group">
                                <label for="">Image</label><br>
                                <input type="file"  id="image"  name ="image"> <img src="{{ $data->image }}" width="180px" alt=""/>

                            </div>   
                            
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary"   value="Update">
                            </div>
                        <br><br><br>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

