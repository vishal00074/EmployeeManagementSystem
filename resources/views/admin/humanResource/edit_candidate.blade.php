@extends('admin.humanResource.app')


@section('content')
 <!-- Content area  -->


<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Edit Candidate Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/humanResource/candidate') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">

                    <form  action="{{ route('candidate.update', ['id' => $data->id]) }}" class="canidate" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $data->name }}"> 
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $data->email }}"> 
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $data->phone }}"> 
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $data->address }}"> 
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                           <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current Resume</label>
                                        @if($data->resume_path != '')
                                        <a class="btn btn-primary" href="{{ url($data->resume_path) }}" target="_blank">View</a>
                                        @else
                                            <p>No resume  uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Upload New Resume</label>
                                        <input type="file" class="form-control" name="resume">
                                        @if ($errors->has('resume'))
                                            <span class="text-danger">{{ $errors->first('resume') }}</span>
                                        @endif
                                    </div>
                                </div>


                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current Cover Letter</label>
                                        @if($data->cover_letter_path != '')
                                        <a class="btn btn-primary" href="{{ url($data->cover_letter_path) }}" target="_blank">View</a>
                                        @else
                                            <p>No cover letter uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Upload New Cover Letter</label>
                                        <input type="file" class="form-control" name="cover_letter">
                                        @if ($errors->has('cover_letter'))
                                            <span class="text-danger">{{ $errors->first('cover_letter') }}</span>
                                        @endif
                                    </div>
                                </div>


                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Applied For</label>
                                    <input type="text" class="form-control" name="job_applied_for" value="{{ $data->job_applied_for }}"> 
                                  
                                </div>
                            </div>


                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Status</label>
                                    <select id="job_type" class="form-control" name="status">
                                    <option value="">Select </option>
                                     <option value="new" @if($data->status=='new') selected   @endif>New</option>
                                     <option value="interviewed" @if($data->status=='interviewed') selected   @endif>Interviewed</option>
                                     <option value="hired" @if($data->status=='hired') selected   @endif>Hired</option>
                                     <option value="rejected" @if($data->status=='rejected') selected    @endif>Rejected</option>

                                   
                                 </select>
                                @if ($errors->has('job_type'))
                                    <span class="text-danger">{{ $errors->first('job_type') }}</span>
                                @endif
                              </div>
                            </div>


                          
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Experience</label>
                                     <input type="text" class="form-control" name="experience" value="{{ $data->experience }}"> 
                                   
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="text" class="form-control" name="position" value="{{ $data->position }}"> 
                                  
                                </div>
                            </div>
                            @php 

                            $shifts = DB::table('shifts')->select('*')->get();

                            @endphp

                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control" id="shift" name="shift"> 
                                        <option value="">Select Shift</option>

                                        @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" @if($data->shift == $shift->id) selected   @endif>{{ $shift->type }} Timing: {{ $shift->timing }}</option>    
                                        @endforeach                         
                                    </select>
                                    @if ($errors->has('shift'))
                                        <span class="text-danger">{{ $errors->first('shift') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Past Salary</label>
                                        <input type="number" class="form-control" name="past_salary" value="{{ $data->past_salary }}" >
                                       
                                    </div>
                             </div>

                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expected_ Salary</label>
                                        <input type="number" class="form-control" name="expected_salary" value="{{ $data->expected_salary }}">
                                       
                                    </div>
                             </div>

                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Offered Salary</label>
                                        <input type="number" class="form-control" name="offered_salary" value="{{ $data->offered_salary }}">
                                         @if ($errors->has('offered_salary'))
                                        <span class="text-danger">{{ $errors->first('offered_salary') }}</span>
                                        @endif
                                       
                                    </div>
                             </div>


                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reason for Change</label>
                                    <textarea type="text" class="form-control" name="reason_for_change">{{ $data->reason_for_change }} </textarea>
                                    @if ($errors->has('reason_for_change'))
                                        <span class="text-danger">{{ $errors->first('reason_for_change') }}</span>
                                    @endif
                                </div>
                            </div>

                           

                            <!-- Employee multi-select dropdown -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last working Day/ Notice Period</label>
                                    <input type="text" class="form-control" name="lwd_np" value="{{ $data->lwd_np }}">
                                    @if ($errors->has('lwd_np'))
                                    <span class="text-danger">{{ $errors->first('lwd_np') }}</span>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".canidate").length > 0) {
            $(".canidate").validate({
                rules: {
                    company_name: 'required',
                    job_title: 'required',

                    job_position: 'required',
                    job_type: 'required',
                    job_location: 'required',
                    qualification: 'required',
                    experience: 'required',
                    job_skill: 'required',
                    job_budget: 'required',
                    job_description: 'required',
                    key_responsibilities: 'required',
                    interview_mode: 'required',
                    email: 'required',
                    lwd_np:'required',
                    shift: 'required',

                },
                messages: {
                    company_name: "Company Name field is required.",
                    job_title: "job title field is required.",

                    job_position: "job position field is required.",
                    job_type: "job type field is required.",
                    job_location: "job location email field is required.",
                    qualification: "qualification  field is required.",
                    experience: "experience field is required.",

                    job_skill: "job skill field is required.",
                    job_budget: "job budget field is required.",
                    job_description: "Job description field is required.",
                    key_responsibilities: "key responsibilities field is required.",

                    interview_mode: "intervier mode field is required.",
                    email: "email field is required.",
                    lwd_np:'Last working day field is required.',
                    shift: "Shift field is required.",


                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>

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



    $(document).ready(function() {
        // Listen for changes in the Shift select input
        $('#shift').change(function() {
            // Get the selected value of the Shift input
            var selectedShift = $(this).val();
                 
            // If the selected shift is "Day", hide the option with value "8.00pm to 5.00am"
            if (selectedShift === 'Day') {
                $('#timing option[value="9.30am to 6.30am"]').show();
                $('#timing option[value="8.00pm to 5.00am"]').hide();

            } else {
                // If the selected shift is not "Day", show the option with value "8.00pm to 5.00am"
                $('#timing option[value="8.00pm to 5.00am"]').show();
                $('#timing option[value="9.30am to 6.30am"]').hide();

            }
        });
    });
</script>



@endsection

