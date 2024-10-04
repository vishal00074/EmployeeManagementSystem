@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4><b>Leave Detail</b></h4>
                    </div>
                </div>
                <br>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Leave Type:</b> {{ $leave_status->leave_name }}
                    </div>
                    <div class="col-md-6">
                        <b>Total Assign:</b> {{ $leave_status->days }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Leave Start Date:</b> {{ \Carbon\Carbon::parse($leave_status->start_date)->format('j F Y') ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Leave End Date:</b> {{ \Carbon\Carbon::parse($leave_status->end_date)->format('j F Y') ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Used Leave:</b> {{ $leave_status->used_leave }}
                    </div>

                </div>
                <hr>

                <h5 class="mb-3">Applied Leave Status</h5>
                <form method="POST" action="{{ url('employee/team-member-leave') }}/{{ $id }}">
                    @csrf
                    <input type="hidden" name="assign_id" value="{{ $data->assign_id }}">
                    <input type="hidden" name="emp_id" value="{{ $data->emp_id }}">
                    <input type="hidden" name="leave_type" value="{{ $data->leave_type }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control" value="{{ $data->employee->name }}" readonly>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <input type="text" class="form-control" value="{{ $data->leavetype->name   }}" readonly>


                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($data->date)->format('Y-m-d') }}" readonly>
                                @if ($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 mt-4">
                                <i class="fa fa-date mr-2"></i>Day Type<br>
                                <select class="form-control" name="day_type" id="day_type" readonly>
                                    <option value="">Select</option>
                                    <option value="0" @if($data->day_type == '0') selected @endif>Half Day</option>
                                    <option value="1"  @if($data->day_type == '1') selected @endif>Full Day</option>
                                </select>
                                @if ($errors->has('day_type'))
                                <span class="text-danger">{{ $errors->first('day_type') }}</span>
                                @endif
                            </div>
                      

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" readonly>
                                    <option value="">Select</option>
                                    <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $data->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $data->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>

                     
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Approved By</label>
                                <input type="text" class="form-control" name="approved_by" value="{{ auth()->guard('employee')->user()->name  }}" readonly>

                                @if ($errors->has('approved_by'))
                                <span class="text-danger">{{ $errors->first('approved_by') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Approved At</label>
                                <input type="datetime-local" class="form-control" name="approved_at" value="{{ $data->approved_at ? \Carbon\Carbon::parse($data->approved_at)->format('Y-m-d\TH:i') : '' }}">


                                @if ($errors->has('approved_at'))
                                <span class="text-danger">{{ $errors->first('approved_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remark</label>
                                <input type="text" class="form-control" name="remark" value="{{ $data->remark ?? '' }}">


                                @if ($errors->has('remark'))
                                <span class="text-danger">{{ $errors->first('remark') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea type="text" class="form-control" id="editor" name="reason" readonly>{{ $data->reason}}</textarea>
                                @if ($errors->has('reason'))
                                <span class="text-danger">{{ $errors->first('reason') }}</span>
                                @endif
                            </div>
                        </div>


                    </div>
                    @if( $data->status != 'approved')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                    @endif
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


@endsection