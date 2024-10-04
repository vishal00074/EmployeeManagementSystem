@extends('employee.layouts.app')
@section('content')
<!--  -->
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Apply For Leave</b></h4>
                    </div>
                </div>
                <div class="row">
                     <div class="col-6 col-md-6 mb-4" align="left">
                       <!-- <button type="submit" data-toggle="modal" data-target="#project_model" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Update Report
                        </button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>


                <br>
                <!--  -->
                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment table-bordered">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Leave Type</th>
                                <th>Assigned Leave</th>
                                <th>Used Leave</th>
                                <th>Total Leave</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">

                            @if(count($leaves)> 0)
                            @foreach($leaves as $leave)
                            <tr>
                                <td>{{ $leave->leave_name ?? '' }}</td>
                                <td>{{ $leave->days ?? '' }}</td>
                                <td>{{ $leave->used_leave ?? '' }}</td>
                                <td>{{ $leave->total_leave ?? '' }}</td>
                                <td>{{ isset( $leave->start_date) ? \Carbon\Carbon::parse( $leave->start_date)->format('l, j F Y') : '' }}</td>
                                <td>{{ isset( $leave->end_date) ? \Carbon\Carbon::parse( $leave->end_date)->format('l, j F Y') : '' }}</td>

                                @if($leave->total_leave == '0')
                                <td> <button class="btn btn-success" disabled>
                                       Apply
                                    </button></td>
                                @else
                                <td> <a href="{{ url('employee/leave-apply') }}/{{ $leave->assign_id }}" class="btn btn-success">
                                       Apply
                                    </a></td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                            <td align="center" colspan="7">Admin has not assigned you leave</td>
                            </tr>
                            @endif


                        </tfoot>
                    </table>
                    {!! $leaves->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>



<!--  -->


@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

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