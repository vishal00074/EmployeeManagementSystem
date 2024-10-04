@extends('admin.humanResource.app')


@section('content')
 <!-- Content area  -->


<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Interview Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
			    <a class="btn btn-success" href="{{ url('admin/humanResource/interview') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                               <div class="col-md-6">
                                <div class="form-group">
                                    <label>Candidate Name</label>
                                    <select id="candidate_id" class="form-control" name="candidate_id" disabled>
                                        <option value="">Select Candidate</option>
                                        @foreach($candidates as $candidate)
                                            <option value="{{ $candidate->id }}" {{ $candidate->id == $data->candidate_id ? 'selected' : '' }}>
                                                {{ $candidate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('candidate_id'))
                                        <span class="text-danger">{{ $errors->first('candidate_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department" id="department" disabled>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ $department->id == $data->department ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('department'))
                                        <span class="text-danger">{{ $errors->first('department') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Interviewer Name</label>
                                    <select id="interviewer_name" class="form-control" name="interviewer_name" disabled>
                                        <option value="">Select Interviewer</option>
                                        @foreach($interviewers as $interviewer)
                                            <option value="{{ $interviewer->id }}" {{ $interviewer->id == $data->interviewer_name ? 'selected' : '' }}>
                                                {{ $interviewer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('interviewer_name'))
                                        <span class="text-danger">{{ $errors->first('interviewer_name') }}</span>
                                    @endif
                                </div>
                            </div>

<!-- Add other dropdowns with similar code -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Interview Date Time</label>
                                    <input type="datetime-local" class="form-control" name="interview_date_time" value="{{ $data->interview_date_time}}" readonly> 
                                    @if ($errors->has('interview_date_time'))
                                        <span class="text-danger">{{ $errors->first('interview_date_time') }}</span>
                                    @endif
                                </div>
                            </div>
<!-- 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>interview_feedback</label>
                                    <input type="file" class="form-control" name="interview_feedback"> 
                                    @if ($errors->has('interview_feedback'))
                                        <span class="text-danger">{{ $errors->first('interview_feedback') }}</span>
                                    @endif
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Interview Status</label>
                                    <select id="interview_status" class="form-control" name="interview_status" disabled>
                                    <option value="">Select </option>
                                     <option value="scheduled" @if($data->interview_status=='scheduled') selected @endif>Scheduled</option>
                                     <option value="attend" @if($data->interview_status=='attend') selected @endif>Attend</option>
                                     <option value="not_attend" @if($data->interview_status=='not_attend') selected @endif>Not Attend</option>

                                   
                                 </select>
                                @if ($errors->has('interview_status'))
                                    <span class="text-danger">{{ $errors->first('interview_status') }}</span>
                                @endif
                              </div>
                            </div>

                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Interview Type</label>
                                    <select id="interview_type" class="form-control" name="interview_type" disabled>
                                    <option value="">Select </option>
                                     <option value="online" @if($data->interview_type=='online') selected @endif >online</option>
                                     <option value="offline" @if($data->interview_type=='offline') selected @endif>offline</option>

                                   
                                 </select>
                                @if ($errors->has('interview_type'))
                                    <span class="text-danger">{{ $errors->first('interview_type') }}</span>
                                @endif
                              </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Additional Notes</label>
                                    <input type="text" class="form-control" name="additional_notes" value="{{ $data->additional_notes}}" readonly> 
                                  
                                </div>
                            </div>

                        @if($data->interview_status=='attend' &&  $data->interview_status=='not_attend')
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Interview Feedback</label>
                                    <textarea class="form-control" name="interview_feedback" rows="4" readonly>{{ $data->interview_feedback }}</textarea>
                                    @if ($errors->has('interview_feedback'))
                                        <span class="text-danger">{{ $errors->first('interview_feedback') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Follow up action</label>
                                    <input type="text" class="form-control" name="follow_up_action" value="{{ $data->follow_up_actionfollow_up_action}}" readonly> 
                                  
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Next Interview Date</label>
                                    <input type="datetime-local" class="form-control" name="next_interview_date" value="{{ $data->next_interview_date}}" readonly> 
                                  
                                </div>
                            </div>
                         @endif

                            
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </div>
                        </div> -->
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
<script>
    $(document).ready(function() {
        $('#department').change(function() {
            var departmentId = $(this).val();
            console.log(departmentId);

            // Send AJAX request to fetch interviewers based on department
            $.ajax({
                url: "{{ route('getInterviewersByDepartment') }}",
                type: 'GET',
                data: {'department_id': departmentId },
                success: function(response) {
                    // Clear previous options
                    $('#interviewer_name').empty();
                    
                    // Add new options based on the response
                    $.each(response, function(index, interviewer) {
                        $('#interviewer_name').append('<option value="' + interviewer.id + '">' + interviewer.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>



@endsection

