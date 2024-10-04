@extends('admin.customer.extra.app')


@section('content')
 <!-- Content area  -->
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Edit Details</b></h6>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('admin/faqlist1/update', $data->id) }}" method="post" enctype="multipart/form-data"> 
                        @csrf
                        <!--<h4><b>Edit Details</b></h4>-->
                        <div class="row">
                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="{{$data->title}}"> 
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description" value="{{$data->description}}"> 
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Whatsaap</label>
                                    <input type="text" class="form-control" name="whatsapp" value="{{$data->whatsapp}}"> 
                                </div>
                            </div>
                          
                          
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>By Phone</label>
                                    <input type="text" class="form-control" name="byphone" value="{{$data->byphone}}"> 
                                </div>
                            </div>
                            
                            
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Online</label>
                                    <input type="text" class="form-control" name="online" value="{{$data->online}}"> 
                                </div>
                            </div>
                            
                            
                            
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Live Chat</label>
                                    <input type="text" class="form-control" name="livechat" value="{{$data->livechat}}"> 
                                </div>
                            </div>
                            
                            
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Facebook Chat</label>
                                    <input type="text" class="form-control" name="facebookchat" value="{{$data->facebookchat}}"> 
                                </div>
                            </div>
                            
                            
                            
                            
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$data->email}}"> 
                                </div>
                            </div>
                            
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Skype Call</label>
                                    <input type="text" class="form-control" name="skypecall" value="{{$data->skypecall}}"> 
                                </div>
                            </div>
                            
                            
                             
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection