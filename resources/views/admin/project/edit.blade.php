@extends('admin.project.app')
 

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
			    <a class="btn btn-success" href="{{ url('admin/project') }}">Back</a>
            </div>
        </div>
        
       
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('project.update', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!--<h4><b>Add Details</b></h4>-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input type="text" class="form-control" name="project_name" value="{{ $data->project_name}}">
                                            @if ($errors->has('project_name'))
                                            <span class="text-danger">{{ $errors->first('project_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" class="form-control" name="client_name" value="{{ $data->client_name}}">
                                            @if ($errors->has('client_name'))
                                            <span class="text-danger">{{ $errors->first('client_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Id</label>
                                            <input type="number" class="form-control" name="project_id" value="{{ $data->project_id}}">
                                            @if ($errors->has('project_id'))
                                            <span class="text-danger">{{ $errors->first('project_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Agency Id</label>
                                            <select id="agency_id" class="form-control" name="agency_id">
                                                <option value="">Select Agency Id</option>
                                                @foreach($agency as $agencys)
                                                <option value="{{ $agencys->id }}" {{ $agencys->id == $data->agency_id ? 'selected' : '' }}>{{ $agencys->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('agency_id'))
                                            <span class="text-danger">{{ $errors->first('agency_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upwork Id</label>
                                            <select id="upwork_id" class="form-control" name="upwork_id">
                                                @foreach($upworks as $upwork)
                                                <option value="{{ $upwork->id }}" {{ $upwork->id == $data->upwork_id ? 'selected' : '' }}>{{ $upwork->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('upwork_id'))
                                            <span class="text-danger">{{ $errors->first('upwork_id') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Type</label>
                                            <select class="form-control" name="project_type" id="project_type">
                                                <option value="">Select</option>
                                                <option value="Fixed" @if($data->project_type == 'Fixed') selected @endif>Fixed</option>
                                                <option value="Billing" @if($data->project_type == 'Billing') selected @endif>Billing</option>

                                            </select>
                                            @if ($errors->has('project_type'))
                                            <span class="text-danger">{{ $errors->first('project_type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="billing_columns" style="display: none;">
                                        <div class="form-group">
                                            <label>Billing Hours</label>
                                            <input type="number" class="form-control" name="billing_hours" value="{{ $data->billing_hours}}">
                                            @if ($errors->has('billing_hours'))
                                            <span class="text-danger">{{ $errors->first('billing_hours') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="billing_price_columns" style="display: none;">
                                        <div class="form-group">
                                            <label> BIlling Price(hour)</label>
                                            <input type="number" class="form-control" name="billing_per_hour_price" value="{{ $data->billing_per_hour_price}}">
                                            @if ($errors->has('billing_per_hour_price'))
                                            <span class="text-danger">{{ $errors->first('billing_per_hour_price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="fixed_columns" style="display: none;">
                                        <div class="form-group">
                                            <label>Total Amount</label>
                                            <input type="number" class="form-control" name="fixed_total_amount" value="{{ $data->fixed_total_amount}}">
                                            @if ($errors->has('fixed_total_amount'))
                                            <span class="text-danger">{{ $errors->first('fixed_total_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select id="department" class="form-control" name="department">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $department->id == $data->department ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department'))
                                            <span class="text-danger">{{ $errors->first('department') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @php
                                    $Demployees = DB::table('employees')->where('department', $data->department)->get();
                                    $emp_explode= explode(',',$data->emp_name);
                                  
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Employee Name</label><br>
                                            <select id="emp_name" class="form-control" name="emp_name[]" multiple>
                                                @foreach($Demployees as $Demployee)
                                                <option value="{{ $Demployee->id }}" @if(in_array($Demployee->id, $emp_explode))
                                                    selected
                                                    @endif >{{ $Demployee->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('emp_name'))
                                            <span class="text-danger">{{ $errors->first('emp_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Description</label>
                                            <textarea type="text" class="form-control" name="project_description">{{ $data->project_description }}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Assign Date</label>
                                            <input type="date" class="form-control" name="assign_date" value="{{ \Carbon\Carbon::parse($data->assign_date)->format('Y-m-d') }}">
                                            @if ($errors->has('assign_date'))
                                            <span class="text-danger">{{ $errors->first('assign_date') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>

                                            <select class="form-control" name="project_status">
                                                <option value="">Select</option>
                                                <option value="Completed" @if($data->project_status == 'Completed') selected @endif>Completed</option>
                                                <option value="In-Processing" @if($data->project_status == 'In-Processing') selected @endif>In-Processing</option>
                                                <option value="Pending" @if($data->project_status == 'Pending') selected @endif>Pending</option>
                                            </select>
                                            @if ($errors->has('project_status'))
                                            <span class="text-danger">{{ $errors->first('project_status') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                    @if ($data->project_status == 'Completed')

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Feedback Comment</label>
                                            <textarea type="text" class="form-control" name="feedback_comment"> @if (isset($data->feedback_comment)) {{ $data->feedback_comment }} @endif
                                       
                                    </textarea>

                                        </div>
                                    </div>
                                    @endif




                                    @if ($data->project_status == 'Completed')



                                    <div class="col-md-6" style="margin-top:37px;">
                                        <div class="form-group">

                                            <label class="mr-2" style="font-size: 25px;">Feedback</label>
                                            @php
                                                $maxStars = 5; 
                                                if($data->star_rating == null){
                                                    $value = 0;  
                                                }else{
                                                    $value = $data->star_rating;
                                                }
                                                

                                                for ($i = 1; $i <= $maxStars; $i++) {
                                                    // Determine if the current star should be filled or empty
                                                    $starClass = $i <= $value ? 'fas' : 'far';

                                                    // Output the star label with the appropriate class
                                                    echo '<label style="color: #fdcc0d;" class="star star-' . $i . '" for="star-' . $i . '">';
                                                    echo '<i class="fa-2x ' . $starClass . ' fa-star"></i>';
                                                    echo '</label>';
                                                }
                                            @endphp
                                            <input type="hidden" id="star-rating" name="star_rating">
                                        </div>
                                    </div>
                                    @endif




                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#emp_name').multiselect({
            nonSelectedText: 'Select Employee',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '400px'
        });

    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    $(document).ready(function() {
       
    });
    
    $('#department').on('change', function() {
        var departmentId = $(this).val();
       
        var multiple_select = $('.multiselect-container .active');

        var emp_name = $('#emp_name');
        $.ajax({
            url: "{{ url('getEmployees') }}",
            type: 'GET',
            data: {
                'department_id': departmentId
            },
            success: function(response) {

                var options = '';
                multiple_select.empty();
                emp_name.empty();

                response.forEach(function(employee) {
                    options += '<option value="' + employee.id + '">' + employee.name + '</option>';
                });
                $('#emp_name').append(options);
                $('#emp_name').multiselect('rebuild');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $(document).ready(function() {
        $('#agency_id').trigger('change');
    });

    $('#agency_id').change(function() {
        var agencyId = $(this).val();

        $.ajax({
            url: "{{ url('fetch-upwork-options') }}",
            data: {
                'agencyId': agencyId
            },
            type: 'GET',
            success: function(response) {
                var options = '<option value="">Select Upwork Id</option>';
                response.forEach(function(upwork) {
                    options += '<option value="' + upwork.id + '">' + upwork.name + '</option>';
                });
                $('#upwork_id').html(options);
                var selectedUpworkId = "{{ $data->upwork_id }}";
                $('#upwork_id').val(selectedUpworkId);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
<script type="text/javascript">
    var projectType = "{{ $data->project_type }}";

    if (projectType === 'Billing') {
        document.getElementById('billing_columns').style.display = 'block';
        document.getElementById('billing_price_columns').style.display = 'block';
        document.getElementById('fixed_columns').style.display = 'none';
    } else if (projectType === 'Fixed') {
        document.getElementById('billing_columns').style.display = 'none';
        document.getElementById('billing_price_columns').style.display = 'none';
        document.getElementById('fixed_columns').style.display = 'block';
    }

    // Add event listener to the project type dropdown
    document.getElementById('project_type').addEventListener('change', function() {
        var projectType = this.value;

        // Show or hide columns based on the selected project type
        if (projectType === 'Billing') {
            document.getElementById('billing_columns').style.display = 'block';
            document.getElementById('billing_price_columns').style.display = 'block';
            document.getElementById('fixed_columns').style.display = 'none';
        } else if (projectType === 'Fixed') {
            document.getElementById('billing_columns').style.display = 'none';
            document.getElementById('billing_price_columns').style.display = 'none';
            document.getElementById('fixed_columns').style.display = 'block';
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.star').on('click', function() {
            var value = $(this).attr('class').split(' ')[1].split('-')[1];
            $('#star-rating').val(value);

            $('.star').each(function() {
                if ($(this).attr('class').split(' ')[1].split('-')[1] <= value) {
                    $(this).find('i').removeClass('far').addClass('fas');
                } else {
                    $(this).find('i').removeClass('fas').addClass('far');
                }
            });
        });
    });
</script>




<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".contracts").length > 0) {
            $(".contracts").validate({
                rules: {
                    project_name: 'required',
                    client_name: 'required',
                    project_id: 'required',
                    agency_id: 'required',
                    upwork_id: 'required',
                    project_type: 'required',
                    department: 'required',
                    emp_name: 'required',
                    project_description: 'required',
                    assign_date: 'required',
                    project_status: 'required',


                },
                messages: {
                    project_name: "project name field is required.",
                    client_name: "client name field is required.",
                    project_id: "project id field is required.",
                    agency_id: "agency id  field is required.",
                    upwork_id: "upwork id  field is required.",
                    project_type: "project type field is required.",
                    department: "department field is required.",
                    emp_name: "emp name field is required.",
                    project_description: "project description field is required.",
                    assign_date: "assign date field is required.",
                    project_status: "project status field is required.",

                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }

    });
</script>
@endsection

