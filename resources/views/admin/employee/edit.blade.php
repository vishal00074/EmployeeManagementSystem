@extends('admin.employee.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Edit Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/employee') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('employee.update', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data" class="employee">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Id</label>
                                    <input type="text" class="form-control" name="employee_id" value="{{ $data->employee_id }}">
                                    @if ($errors->has('employee_id'))
                                    <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            
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
                                    <label>Official Email</label>
                                    <input type="text" class="form-control" name="official_email" value="{{ $data->official_email }}">
                                    @if ($errors->has('official_email'))
                                    <span class="text-danger">{{ $errors->first('official_email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                    @if ($errors->has('confirm_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <input type="file" class="form-control" name="photo" id="photo">
                                    @if ($errors->has('photo'))
                                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    @endif
                                    <img src="{{ url($data->photo) }}" height="120px" width="150px" alt="image">
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="sex">
                                        <option value="">Select</option>
                                        <option value="Male" @if($data->sex == 'Male')selected @endif>Male</option>
                                        <option value="Female" @if($data->sex == 'Female')selected @endif>Female</option>
                                    </select>
                                    @if ($errors->has('sex'))
                                    <span class="text-danger">{{ $errors->first('sex') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile_number" value="{{ $data->mobile_number }}">
                                    @if ($errors->has('mobile_number'))
                                    <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Personal Email</label>
                                    <input type="email" class="form-control" name="personal_email" value="{{ $data->personal_email }}">
                                    @if ($errors->has('personal_email'))
                                    <span class="text-danger">{{ $errors->first('personal_email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="{{ \Carbon\Carbon::parse($data->dob)->format('Y-m-d') }}">
                                    @if ($errors->has('dob'))
                                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Of Joining</label>
                                    <input type="date" class="form-control" name="joining_date" value="{{ \Carbon\Carbon::parse($data->joining_date)->format('Y-m-d') }}">
                                    @if ($errors->has('joining_date'))
                                    <span class="text-danger">{{ $errors->first('joining_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="">Select</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}" @if($data->department == $department->id) selected @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('department'))
                                    <span class="text-danger">{{ $errors->first('department') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <select class="form-control" name="designation">
                                        <option value="">Select</option>
                                        @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" @if($data->designation == $designation->id) selected @endif>{{ $designation->designation_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('designation'))
                                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Address</label>
                                    <textarea class="form-control" name="current_address">{{ $data->current_address }}</textarea>
                                    @if ($errors->has('current_address'))
                                    <span class="text-danger">{{ $errors->first('current_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Permanant Address</label>
                                    <textarea class="form-control" name="permanant_address">{{ $data->permanant_address }}</textarea>
                                    @if ($errors->has('permanant_address'))
                                    <span class="text-danger">{{ $errors->first('permanant_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Adhar Number</label>
                                    <input type="text" class="form-control" name="adhar_number" value="{{ $data->adhar_number }}">
                                    @if ($errors->has('adhar_number'))
                                    <span class="text-danger">{{ $errors->first('adhar_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pan Number</label>
                                    <input type="text" class="form-control" name="pan_number" value="{{ $data->pan_number }}">
                                    @if ($errors->has('pan_number'))
                                    <span class="text-danger">{{ $errors->first('pan_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Working Saturday</label>
                                    <select class="form-control" name="working_saturday">
                                        <option value="">Select</option>
                                        <option value="1,3" @if($data->working_saturday == '1,3') selected @endif>1,3</option>
                                        <option value="2,4" @if($data->working_saturday == '2,4') selected @endif>2,4</option>
                                    </select>
                                    @if ($errors->has('working_saturday'))
                                    <span class="text-danger">{{ $errors->first('working_saturday') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control" name="shift">
                                        <option value="">Select</option>
                                        @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" @if($data->shift == $shift->id) selected @endif>{{ $shift->type }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('shift'))
                                    <span class="text-danger">{{ $errors->first('shift') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gross Salary</label>
                                    <input type="text" class="form-control" name="gross_salary" value="{{ $data->gross_salary }}">
                                    @if ($errors->has('gross_salary'))
                                    <span class="text-danger">{{ $errors->first('gross_salary') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Esi Number</label>
                                    <input type="text" class="form-control" name="esi_number" value="{{ $data->esi_number ?? '' }}">
                                    @if ($errors->has('esi_number'))
                                    <span class="text-danger">{{ $errors->first('esi_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PF Number</label>
                                    <input type="text" class="form-control" name="pf_number" value="{{ $data->pf_number ?? '' }}">
                                    @if ($errors->has('pf_number'))
                                    <span class="text-danger">{{ $errors->first('pf_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reporting To</label>
                                    <select class="form-control" name="reporting_to" id="reporting_to">
                                        <option value="{{ $data->reporting_id }}">{{ $data->reporting_name }}</option>
                                        
                                          @foreach($employee_array as $reporting_emp)
                                        <option value="{{ $reporting_emp['id'] }}">{{ $reporting_emp['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('reporting_to'))
                                    <span class="text-danger">{{ $errors->first('reporting_to') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                    



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select</option>
                                        <option value="1" @if($data->status == '1') selected @endif>Active</option>
                                        <option value="0" @if($data->status == '0') selected @endif>Inactive</option>
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
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
<!-- photo gross salary esi number pf number -->
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".employee").length > 0) {
            $(".employee").validate({
                rules: {
                    official_email: 'required',
                    name: 'required',
                    password: {

                        minlength: 6
                    },
                    confirm_password: {

                        equalTo: '#password'
                    },
                    sex: 'required',
                    mobile_number: 'required',
                    personal_email: 'required',
                    dob: 'required',
                    joining_date: 'required',
                    department: 'required',
                    designation: 'required',
                    current_address: 'required',
                    permanant_address: 'required',
                    adhar_number: 'required',
                    pan_number: 'required',
                    working_saturday: 'required',
                    shift: 'required',
                    reporting_to: 'required',
                    status: 'required',
                    gross_salary: 'required',
                    gross_salary: 'required',
                },
                messages: {
                    official_email: "Official Email field is required.",
                    official_email: "name Email field is required.",
                    password: {
                        minlength: "Password must be at least 6 characters."
                    },
                    confirm_password: {
                        equalTo: "Passwords do not match."
                    },
                    sex: "Gender field is required.",
                    mobile_number: "Mobile number field is required.",
                    personal_email: "Personal email field is required.",
                    dob: "Date of birth field is required.",
                    joining_date: "Joining date field is required.",
                    department: "Department field is required.",
                    designation: "Designation field is required.",
                    current_address: "Current address field is required.",
                    permanant_address: "Permanant Address field is required.",
                    adhar_number: "Adhar number field is required.",
                    pan_number: "Pan number field is required.",
                    working_saturday: "Working Saturday field is required.",
                    shift: "Shift field is required.",
                    reporting_to: "Reporting to field is required.",
                    status: "Status field is required.",
                    gross_salary: "Gross Salary field is required.",


                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#department').on('change', function() {
            var departmentID = $('#department').val();
            var reporting_to = $('#reporting_to');

            $.ajax({
                url: "{{ url('admin/department_employee') }}",
                method: 'POST',
                data: {
                    departmentID: departmentID
                },
                success: function(response) {
                    result = response.data
                    reporting_to.empty();
                    var data = '<option value="0">Admin</option>'; 
                    for (var i = 0; i < response.data.length; i++) { 
                        data += '<option value="' + response.data[i].id + '">' + response.data[i].name + '</option>'; 
                    }
                    reporting_to.append(data);

                    console.log('Data sent successfully!', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
@endsection