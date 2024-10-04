@extends('admin.humanResource.app')
 

@section('content')
 <!-- Content area  -->
<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Update Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/humanResource') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="{{ route('humanResource.update', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- value="{{ $data->client_name}}">  -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name" value="{{ $data->company_name}}">
                                    @if ($errors->has('company_name'))
                                        <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Title</label>
                                    <input type="text" class="form-control" name="job_title" value="{{ $data->job_title}}"> 
                                    @if ($errors->has('job_title'))
                                        <span class="text-danger">{{ $errors->first('job_title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Position</label>
                                    <input type="text" class="form-control" value="{{ $data->job_position}}" name="job_position"> 
                                    @if ($errors->has('job_position'))
                                        <span class="text-danger">{{ $errors->first('job_position') }}</span>
                                    @endif
                                </div>
                            </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Job Type</label>
                                    <select id="job_type" class="form-control" name="job_type">
                                    <option value="">Select Job Type</option>
                                     <option value="Full Time" @if($data->job_type =='Full Time') selected @endif >Full Time</option>
                                     <option value="Contract" @if($data->job_type =='Contract') selected @endif >Contract</option>
                                   
                                 </select>
                                @if ($errors->has('job_type'))
                                    <span class="text-danger">{{ $errors->first('job_type') }}</span>
                                @endif
                              </div>
                            </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Job Location</label>
                                    <select class="form-control" id="upwork_id" name="job_location"> 

                                         <option value="">Select Location</option>
                                         <option value="Chandigarh" @if($data->job_location =='Chandigarh') selected @endif >Chandigarh</option>
                                         <option value="Client Location" @if($data->job_location =='Client Location') selected @endif >Client Location</option>                               
                                     
                                     </select>
                                    @if ($errors->has('job_location'))
                                        <span class="text-danger">{{ $errors->first('job_location') }}</span>
                                    @endif
                                 </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Qualification</label>
                                     <input type="text" class="form-control" value="{{ $data->qualification}}"name="qualification"> 
                                      @if ($errors->has('qualification'))
                                        <span class="text-danger">{{ $errors->first('qualification') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Experience</label>
                                    <input type="text" class="form-control" value="{{ $data->experience}}" name="experience"> 
                                    @if ($errors->has('experience'))
                                        <span class="text-danger">{{ $errors->first('experience') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Job Skill</label>
                                    <input type="text" class="form-control" data-role="tagsinput" name="job_skill" value="{{ $data->job_skill}}"> 
                                    @if ($errors->has('job_skill'))
                                        <span class="text-danger">{{ $errors->first('job_skill') }}</span>
                                    @endif
                                </div>  
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Budget</label>
                                        <input type="text" class="form-control" name="job_budget" value="{{ $data->job_budget}}">
                                       
                                    </div>
                            </div>


                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Description</label>
             <textarea type="text" class="form-control" name="job_description">{{ $data->job_description}}</textarea>
                                    @if ($errors->has('job_description'))
                                        <span class="text-danger">{{ $errors->first('job_description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select class="form-control" id="upwork_id" name="shift"> 

                                         <option value="">Select Shift</option>
                                         <option value="Day" @if($data->shift =='Day') selected @endif >Day </option>
                                         <option value="Night" @if($data->shift =='Night') selected @endif>Night</option>                               
                                     
                                     </select>
                                        @if ($errors->has('shift'))
                                            <span class="text-danger">{{ $errors->first('shift') }}</span>
                                        @endif
                                    </div>
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Timing</label>
                                        <input type="text" class="form-control" name="timing" value="{{ $data->timing}}">
                                        @if ($errors->has('timing'))
                                            <span class="text-danger">{{ $errors->first('timing') }}</span>
                                        @endif
                                    </div>
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Key Responsibility</label>
                                          <textarea type="text" class="form-control" name="key_responsibilities">{{ $data->key_responsibilities}}</textarea>
                                        @if ($errors->has('key_responsibilities'))
                                            <span class="text-danger">{{ $errors->first('key_responsibilities') }}</span>
                                        @endif
                                    </div>
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Interview Mode</label>
                                        <select class="form-control" id="upwork_id" name="interview_mode"> 

                                         <option value="">Select Location</option>
                                         <option value="Online" @if($data->interview_mode =='Online') selected @endif>Online</option>
                                         <option value="face-to-face"  @if($data->interview_mode =='face-to-face') selected @endif>face-to-face</option>                               
                                     
                                     </select>
                                        @if ($errors->has('interview_mode'))
                                            <span class="text-danger">{{ $errors->first('interview_mode') }}</span>
                                        @endif
                                    </div>
                            </div>


                            <!-- Employee multi-select dropdown -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                         <input type="email" class="form-control" name="email" value="{{ $data->email}}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact  Detail</label>
                                    <textarea type="text" class="form-control" name="contact_detail">{{ $data->contact_detail}}</textarea>
                                     @if ($errors->has('contact_detail'))
                                        <span class="text-danger">{{ $errors->first('contact_detail') }}</span>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> 


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>


<script>
 
 console.clear();

$(function() {
  $('input').on('change', function(event) {
    var $element = $(event.target);
    var $container = $element.closest('.example');

    if (!$element.data('tagsinput'))
      return;

    var val = $element.val();
    if (val === null)
      val = "null";
    var items = $element.tagsinput('items');
    console.log(items[items.length - 1]);

    $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\""));
    $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));

    console.log(val);
    console.log(items);
    console.log(JSON.stringify(val));
    console.log(JSON.stringify(items));

    console.log(items[items.length - 1]);

  }).trigger('change');
});

$("#button").click(function() {
  var input = $("input[name='tags']").tagsinput('items');
  console.clear();
  console.log(input);
  console.log(JSON.stringify(input));
  console.log(input[input.length - 1]);
});

</script>


@endsection

