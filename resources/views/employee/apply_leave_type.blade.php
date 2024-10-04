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
                       <!--  <button type="submit" data-toggle="modal" data-target="#project_model" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Update Report
                        </button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/leave/apply') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>


                <br>
                <div class="col-sm-12 p-0">
                    <div class="table-responsive">
                        <form name="AcceptLicense" class="AcceptLicense" action="{{ url('/employee/leave-apply') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="assign_id" value="{{ $assigned->assign_id }}">
                                    <input type="hidden" name="leave_type" value="{{ $assigned->leave_id }}">
                                    <div class="form-group col-md-12 mt-4">
                                        <i class="fa fa-upload mr-2"></i>Leave Type<br>
                                        <select class="form-control" id="leave_type" disabled>
                                            <option value="{{ $assigned->id }}">{{ $assigned->name }}</option>
                                        </select>
                                        @if ($errors->has('leave_type'))
                                        <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                                        @endif

                                    </div>
                                    <div class="form-group col-md-12 mt-4">
                                        <i class="fa fa-book mr-2"></i>Reason<br>
                                        <textarea name="reason" class="form-control" id="reason"></textarea>
                                        @if ($errors->has('reason'))
                                        <span class="text-danger">{{ $errors->first('reason') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <i class="fa fa-date mr-2"></i>Date<br>
                                        <input type="date" class="form-control" name="date" id="date" required>
                                        @if ($errors->has('date'))
                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <i class="fa fa-date mr-2"></i>Day Type<br>
                                        <select class="form-control" name="day_type" id="day_type" required>
                                            <option value="">Select</option>
                                            <option value="0">Half Day</option>
                                            <option value="1">Full Day</option>
                                        </select>
                                        @if ($errors->has('day_type'))
                                        <span class="text-danger">{{ $errors->first('day_type') }}</span>
                                        @endif
                                    </div>

                                 
                                    <div class="form-group col-md-6 mt-4">
                                        <i class="fa fa-date mr-2"></i>Total Leave Balance<br>
                                        <input type="text" class="form-control" value="{{ $assigned->total_leave }}" readonly>
                                    </div>
                                   
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="form-group col-md-12" align="center">
                                        <input type="submit" class="btn btn-success" value="Submit" id="submitform">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
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
        .create(document.querySelector('#reason'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    $(document).ready(function() {
        $('#getValue').on('click', function() {

            var startdateId = $('#start_date').val();
            var enddateId = $('#end_date').val();
            var day = $('#days');


            const startDate = new Date(startdateId);
            const endDate = new Date(enddateId);

            const timeDifference = endDate - startDate;

            
            const hoursDifference = timeDifference / (1000 * 60 * 60);
            const NumberOfdays = hoursDifference / 9;
            // const RoundNumberOfdays = Math.round(NumberOfdays)
            day.empty();
            day.append(NumberOfdays);

            console.log(`The difference is ${NumberOfdays} hours.`);
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        if ($(".AcceptLicense").length > 0) {
            $(".AcceptLicense").validate({
                rules: {
                    // FranchiseeCode: 'required',
                    leave_type: 'required',
                    reason: 'required',
                    date: 'required',
                    day_type: 'required'
                },
                messages: {
                    // FranchiseeCode: "Franchisee Code field is required.",
                    leave_type: "Leave field is required.",
                    reason: "reason field is required.",
                    date: "date field is required.",
                    day_type: 'Day Type field is required.'
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>

@endsection