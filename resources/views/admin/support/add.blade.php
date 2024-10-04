@extends('admin.support.app')

@section('content')
 <!-- Content area  -->
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Add Message</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
			    <a class="btn btn-success" href="{{ url('admin/support') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="{{ route('support.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <input type="hidden" name="recipient_id" value="{{ $recipientId }}">
                       <input type="hidden" name="support_id" value="{{ $supportId }}">
    <input type="hidden" name="sender_id" value="{{ Auth::guard('admin')->user()->id }}">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="subject" value="{{$data->subject }}" readonly> 
                                   
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" readonly>{{$data->description }}
                            </textarea>
                                   
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Message</label>
                                  <textarea class="form-control" id="message" name="message" rows="3">
                                    </textarea> 
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
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

