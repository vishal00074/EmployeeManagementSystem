@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Job Listing</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <!-- <button type="submit" class="btn btn-info btn-sm">
                            <a href="{{ url('employee/hr/job/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Job</a>
                        </button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/hr/interview') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('hr.interview.update', ['id' => $data->id]) }}" class="interview" method="post" enctype="multipart/form-data">

                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Candidate Name</label>
                                            <select id="candidate_id" class="form-control" name="candidate_id">
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
                                            <select class="form-control" name="department" id="department">
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
                                            <select id="interviewer_name" class="form-control" name="interviewer_name">
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



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Interview Date Time</label>
                                            <input type="datetime-local" class="form-control" name="interview_date_time" id="interview_date_time" value="{{ $data->interview_date_time}}">
                                            @if ($errors->has('interview_date_time'))
                                            <span class="text-danger">{{ $errors->first('interview_date_time') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Interview Status</label>
                                            <select id="interview_status" class="form-control" name="interview_status" id="interview_status">
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
                                            <select id="interview_type" class="form-control" name="interview_type" id="interview_type">
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
                                            <input type="text" class="form-control" name="additional_notes" id="additional_notes" value="{{ $data->additional_notes}}">

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
    </div>
</div>
@endsection


@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

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
                data: {
                    'department_id': departmentId
                },
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