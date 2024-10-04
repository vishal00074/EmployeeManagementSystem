@extends('admin.customer.extra.app')


@section('content')
 
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-body"> 
            <div class="row">
              <div class="col-md-6">
                     <form class="howwamdeworks" action="{{ url('admin/howwamdework',$howwamdework->id)}}" method="POST">
                        @csrf
                        <h1>HowWamdeWorks Details</h1>
                        <div class="row">
                             <input type="hidden"  name="wamdework_data" value="{{$howwamdework->id}}">
                            <div class="col-md-12">
                                 <div class="form-group">
                                <label>Title</label>
                               <input type="text" class="form-control" name="title" value="{{$howwamdework->title}}"> 
                            </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description">{{$howwamdework->description}}</textarea>
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


    
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Services</b></h6>
            </div>
        </div>
    
        <section class="join">
        <h1 class="text-center mb-5">{{$service->abouttitle}}
            </h1>
    	<div class="container">
	        <div class="row">
	           
              <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            	    <div class="inside">
            	       <h3 class="wpe-heading content-panel__headline"><a href="" data-toggle="modal" data-target="#recievemoney">{{$service->title}}</a></h3>
            	        <p>{{$service->description}}
                    	</p>
                	</div>
            	</div>	
            	<div class="col-sm-3">
            	    <div class="inside">
            	           <h3 class="wpe-heading content-panel__headline"><a href="" data-toggle="modal" data-target="#mymoney">{{$servicemoney->title}}</a></h3>
            	        <p>{{$servicemoney->description}}

                    	</p>
                	</div>
            	</div>		
            	<div class="col-sm-3">
                	<div class="inside">
                	    <h3 class="wpe-heading content-panel__headline"><a href="" data-toggle="modal" data-target="#mycontent">{{$servicerecieve->title}}</a></h3>
                    	<p>{{$servicerecieve->description}}
                	    </p>
            	    </div>
        	    </div>		
            	<div class="col-sm-3">
                	<div class="inside">
                      <h4 class="title"><a href="" data-toggle="modal" data-target="#mytitle"></a></h4>
                    	<p>
                    	</p>
                	</div>
            	</div>
	        </div>
    	</div>
    </section>
	</div>
	
	
	
	
	<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-body"> 
            <div class="row">
              <div class="col-md-6">
                     <form class="wamdecategory" action="{{ url('admin/wamdecategory',$category->id)}}" method="POST">
                        @csrf
                      
                        <h1>Category Details</h1>
                        <div class="row">
                             <input type="hidden"  name="category_data" value="{{$category->id}}">
                            <div class="col-md-12">
                                 <div class="form-group">
                                <label>Title</label>
                               <input type="text" class="form-control" name="categorytitle" value="{{$category->categorytitle}}"> 
                            </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="categorydescription" name="description">{{$category->categorydescription}}</textarea>
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
	
	
	<div class="content">
     <!-- Page length options  -->
    <div class="card">
	
	     <div class="card-body"> 
            <div class="row">
                <div class="col-md-6">
                  <form class="wamdecategory" action="{{ url('admin/wamdeworkscategory',$category->id)}}" method="POST">
                        @csrf
                        <h4><b>Create an account in seconds</b></h4>
                        <div class="row">
                            <input type="hidden" name="categoryworks_data" value="{{$category->id}}"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="Title" value="{{$category->title}}"> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="Description" value="{{$category->description}}"> 
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
                <div class="col-md-6">
                <form class="wamdecategory" action="{{ url('admin/wamdeworkscategory',$category1->id)}}" method="POST">
                        @csrf
                        <h4><b>Add payment methods to your wallet</b></h4>
                        <div class="row">
                            <input type="hidden" name="wamdeworks_data" value="{{$category1->id}}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="Title" value="{{$category1->title}}"> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="Description" value="{{$category1->description}}"> 
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

        <div class="modal fade" id="recievemoney" role="dialog" align="center">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                 <h3>Shop and buy online or in person</h3>
                <div class="modal-body">
                   <form class="howwamdeworks" action="{{ url('admin/servicemoney',$service->id)}}" method="POST" align="left">
                    @csrf
                      <input type="hidden" name="online_data" value="{{$service->id}}">  
                    
                        
                  <label> Service Title</label>
                        <input type ="text" name="abouttitle" class="form-control" value="{{$service->abouttitle}}"> 
                        
                  <label> Title</label>
                    <input type ="text" name="title" class="form-control" value="{{$service->title}}">
                    
                    <label> Description</label>
                    <input type ="text" name="description" class="form-control" value="{{$service->description}}" >
                    <br><br>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>
                    </div>
                   </form>
                </div>
              </div>
              
            </div>
          </div>
        <!--//category data -->
        
        <div class="modal fade" id="mymoney" role="dialog" align="center">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                 <h3>Send money securely</h3>
                <div class="modal-body">
                  <form class="howwamdeworks" action="{{ url('admin/servicemoney',$servicemoney->id)}}" method="POST" align="left">
                    @csrf
                      <input type="hidden" name="money_data" value="{{$servicemoney->id}}">  
            
                    <label> Title</label>
                    <input type ="text" name="title" class="form-control" value="{{$servicemoney->title}}">
                    
                      <label> Description</label>
                     <input type ="text" name="description" class="form-control" value="{{$servicemoney->description}}">
                    
                    <br><br>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>
                        </div>
                   </form>
                </div>
              </div>
              
            </div>
          </div>
           
        <div class="modal fade" id="mycontent" role="dialog" align="center">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                 <h3>Receive and collect money</h3>
                <div class="modal-body">
                    <form class="howwamdeworks" action="{{ url('admin/servicemoney',$servicerecieve->id)}}" method="POST" align="left">
                    @csrf
                      <input type="hidden" name="recieve_data" value="{{$servicerecieve->id}}">  
                    
                    <label>Title</label>
                    <input type ="text" name="title" class="form-control" value="{{$servicerecieve->title}}" >
                    
                      <label>Description</label>
                     <input type ="text" name="description" class="form-control" value="{{$servicerecieve->description}}">
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>
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


