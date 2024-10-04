@extends('employee.layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Employee Details</b></h4>
                    </div>
                </div>
                <form action="" method="POST" class="employeeDetail">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $employee->name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <!-- <label class="label" for="password">Photo</label> -->
                                <img src="{{ url($employee->photo) }}" height="130px" width="140px">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Official Email</label>
                                <input type="text" class="form-control" value="{{ $employee->official_email }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Gender</label>
                                <input type="text" class="form-control" name="sex" value="{{ $employee->sex }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Date of birth</label>
                                <input type="text" class="form-control" name="FranchiseeType" value="{{ \Carbon\Carbon::parse($employee->dob)->format('d/m/y') }}
" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Joining Date</label>
                                <input type="text" class="form-control" name="ProgramName" value="{{ \Carbon\Carbon::parse($employee->joining_date)->format('d/m/y') }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Department</label>
                                <input type="text" class="form-control" name="ContactPerson" value="{{ $employee->department_name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Designation</label>
                                <input type="text" class="form-control" name="PhoneNo" value="{{ $employee->designation_name }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Mobile</label>
                                <input type="text" class="form-control" name="MobileNo" value="{{ $employee->mobile_number }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Personal Email</label>
                                <input type="email" class="form-control" name="personal_email" value="{{ $employee->personal_email }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Adhar Code</label>
                                <input type="text" class="form-control" name="Usr_Code" value="{{ $employee->adhar_number }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Pan Number</label>
                                <input type="text" class="form-control" name="pan_number" value="{{ $employee->pan_number }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Reporting To</label>
                                <input type="text" class="form-control" name="reporting_to" value="{{ $employee->reporting_name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Working Saturday</label>
                                <input type="text" class="form-control" name="working_saturday" value="{{ $employee->working_saturday }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Shift Type</label>
                                <input type="text" class="form-control" name="working_saturday" value="{{ $employee->type }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">Timing</label>
                                <input type="text" class="form-control" name="working_saturday" value="{{ $employee->timing }}" readonly="readonly">
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">ESI Number</label>
                                <input type="text" class="form-control" name="working_saturday" value="{{ $employee->esi_number }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label" for="name">PF Number</label>
                                <input type="text" class="form-control" name="working_saturday" value="{{ $employee->pf_number }}" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Current Address</label>
                                <textarea type="text" class="form-control" name="Address" readonly="readonly">{{ $employee->current_address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="label" for="password">Permanant Address</label>
                                <textarea type="text" class="form-control" name="Address" readonly="readonly">{{ $employee->permanant_address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 mt-3 text-md-center">
                            <button type="button" class="form-control btn btn-primary rounded cancel px-3">
                                <a href="{{ url('/employee') }}" class="text-white">DISCARD</a>
                            </button>
                        </div>
                        <div class="col-sm-4"></div>







                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".employeeDetail").length > 0) {
            $(".employeeDetail").validate({
                rules: {
                    // FranchiseeCode: 'required',
                    FranchiseeName: 'required',
                    FranchiseeType: 'required',
                    ProgramName: 'required',
                    ContactPerson: 'required',
                    PhoneNo: 'required',
                    MobileNo: 'required',
                    EmailID: 'required',
                    Usr_Code: 'required',
                    Address: 'required'
                },
                messages: {
                    // FranchiseeCode: "Franchisee Code field is required.",
                    FranchiseeName: "Franchisee name field is required.",
                    FranchiseeType: "Franchisee name field is required.",
                    ProgramName: "Program name field is required.",
                    ContactPerson: "Contact person field is required.",
                    PhoneNo: "Phone number field is required.",
                    MobileNo: "Mobile number field is required.",
                    EmailID: "Email field is required.",
                    Usr_Code: "User code field is required.",
                    Address: "Address field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
@endsection