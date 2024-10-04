@extends('admin.humanResource.app')


@section('content')
 <!-- Content area  -->


<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Add Interview Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
			    <a class="btn btn-success" href="{{ url('admin/humanResource/interview') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="{{ route('interview.save') }}" method="post" class="interview" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Candidate Name</label>
                                        <select id="candidate_id" class="form-control" name="candidate_id">
                                            <option value="">Select Candidate</option>
                                            @foreach($candidates as $candidate)
                                                <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
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
                                <select class="form-control" name="department" id="department">
                                    <option value="">Select Department</option>
                                 
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
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
                                        <select id="interviewer_name" class="form-control" name="interviewer_name">
                                            <option value="">Select Interviewer</option>
                                        </select>
                                        @if ($errors->has('interviewer_name'))
                                            <span class="text-danger">{{ $errors->first('interviewer_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Interview Date Time</label>
                                    <input type="datetime-local" class="form-control" name="interview_date_time"> 
                                    @if ($errors->has('interview_date_time'))
                                        <span class="text-danger">{{ $errors->first('interview_date_time') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Interview Status</label>
                                    <select id="interview_status" class="form-control" name="interview_status">
                                    <option value="">Select </option>
                                     <option value="scheduled">Scheduled</option>
                                     <option value="attend">Attend</option>
                                     <option value="not_attend">Not Attend</option>

                                   
                                 </select>
                                @if ($errors->has('interview_status'))
                                    <span class="text-danger">{{ $errors->first('interview_status') }}</span>
                                @endif
                              </div>
                            </div>

                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Interview Type</label>
                                    <select id="interview_type" class="form-control"  name="interview_type">
                                    <option value="">Select </option>
                                     <option value="online">online</option>
                                     <option value="offline">offline</option>

                                   
                                 </select>
                                @if ($errors->has('interview_type'))
                                    <span class="text-danger">{{ $errors->first('interview_type') }}</span>
                                @endif
                              </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Additional Notes</label>
                                    <input type="text" class="form-control" id="additional_notes" name="additional_notes"> 
                                  
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
        if ($(".interview").length > 0) {
            $(".interview").validate({
                rules: {
                    candidate_id: 'required',
                    department: 'required',

                    interviewer_name: 'required',
                    interview_date_time: 'required',
                    interview_status: 'required',
                    interview_type: 'required',

                    additional_notes: 'required',

                },
                messages: {
                    

                    candidate_id: "candidate field is required.",

                    department: "department field is required.",
                    interviewer_name: "interviewer name field is required.",
                    interview_date_time: "date field is required.",

                    interview_status: "intervier status field is required.",
                    interview_type: "interview type field is required.",

                    additional_notes: "additional notes field is required.",


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

