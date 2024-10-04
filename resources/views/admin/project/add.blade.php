@extends('admin.project.app')


@section('content')
 <!-- Content area  -->


<div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Add Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
			    <a class="btn btn-success" href="{{ url('admin/project') }}">Back</a>
            </div>
        </div>
        
         <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('project.save') }}" class="contracts" method="post" enctype="multipart/form-data">
                                @csrf
                                <!--<h4><b>Add Details</b></h4>-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input type="text" class="form-control" name="project_name">
                                            @if ($errors->has('project_name'))
                                            <span class="text-danger">{{ $errors->first('project_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" class="form-control" name="client_name">
                                            @if ($errors->has('client_name'))
                                            <span class="text-danger">{{ $errors->first('client_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Id</label>
                                            <input type="number" class="form-control" name="project_id">
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
                                                <option value="{{ $agencys->id }}">{{ $agencys->name }} </option>
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
                                            <select class="form-control" id="upwork_id" name="upwork_id">

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
                                                <option value="Fixed">Fixed</option>
                                                <option value="Billing">Billing</option>

                                            </select>
                                            @if ($errors->has('project_type'))
                                            <span class="text-danger">{{ $errors->first('project_type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="billing_columns" style="display: none;">
                                        <div class="form-group">
                                            <label>Billing Hours /per week</label>
                                            <input type="number" class="form-control" name="billing_hours">
                                            @if ($errors->has('billing_hours'))
                                            <span class="text-danger">{{ $errors->first('billing_hours') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="billing_price_columns" style="display: none;">
                                        <div class="form-group">
                                            <label> BIlling Price(hour)</label>
                                            <input type="number" class="form-control" name="billing_per_hour_price">
                                            @if ($errors->has('billing_per_hour_price'))
                                            <span class="text-danger">{{ $errors->first('billing_per_hour_price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="fixed_columns" style="display: none;">
                                        <div class="form-group">
                                            <label>Total Amount</label>
                                            <input type="number" class="form-control" name="fixed_total_amount">
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
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department'))
                                            <span class="text-danger">{{ $errors->first('department') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                    <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <select id="framework" class="form-control" name="emp_name[]" multiple>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('emp_name'))
                                        <span class="text-danger">{{ $errors->first('emp_name') }}</span>
                                    @endif
                                </div>
                            </div> -->

                                    <!-- Employee multi-select dropdown -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Employee Name</label><br>
                                            <select id="emp_name" class="form-control" name="emp_name[]" multiple>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                            @if ($errors->has('emp_name'))
                                            <span class="text-danger">{{ $errors->first('emp_name') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Description</label>
                                            <textarea type="text" class="form-control" name="project_description"></textarea>
                                            @if ($errors->has('project_description'))
                                            <span class="text-danger">{{ $errors->first('project_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Assign Date</label>
                                            <input type="date" class="form-control" name="assign_date">
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
                                                <option value="Completed">Completed</option>
                                                <option value="In-Processing">In-Processing</option>
                                                <option value="Pending">Pending</option>

                                            </select>
                                            @if ($errors->has('project_status'))
                                            <span class="text-danger">{{ $errors->first('project_status') }}</span>
                                            @endif
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


<script>
    // Add event listener to the department dropdown

    document.getElementById('department').addEventListener('change', function() {
        console.log('Department dropdown value changed');

        var departmentId = this.value;

        // Send AJAX request to fetch employees based on department
        $.ajax({


            // url: '/admin/getEmployees',
            url: "{{ url('getEmployees') }}",

            type: 'GET',
            data: {
                'department_id': departmentId
            },
            success: function(response) {
                // Update employee multi-select dropdown options based on the response
                var options = '';
                response.forEach(function(employee) {
                    options += '<option value="' + employee.id + '">' + employee.name + '</option>';
                });
                $('#emp_name').html(options);
                $('#emp_name').multiselect('rebuild');
            }
        });
    });


    // Add event listener to the agency dropdown
    $('#agency_id').change(function() {

        var agencyId = $(this).val();

        // Send AJAX request to fetch upwork options based on agency_id
        $.ajax({

            url: "{{ url('fetch-upwork-options') }}",
            data: {
                'agencyId': agencyId
            },
            type: 'GET',
            success: function(response) {
                // Update upwork dropdown options based on the response
                var options = '<option value="">Select Upwork Id</option>';
                response.forEach(function(upwork) {
                    options += '<option value="' + upwork.id + '">' + upwork.name + '</option>';
                });
                $('#upwork_id').html(options);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>


<script>
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




<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

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