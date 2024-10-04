@extends('admin.leave.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Leave Detail</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/leave') }}">Back</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4><b> Employee Leave Status</b></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b> Leave Type</b></label>
                            <p class="form-control-static">{{ $leave_status->leave_name }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Total Assign</b></label>
                            <p class="form-control-static">{{ $leave_status->days }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Leave Start Date</b></label>
                            <p class="form-control-static">{{ \Carbon\Carbon::parse($leave_status->start_date)->format('j F Y') ?? '' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Leave End Date</b></label>
                            <p class="form-control-static">{{ \Carbon\Carbon::parse($leave_status->end_date)->format('j F Y') ?? '' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Used Leave</b></label>
                            <p class="form-control-static">{{ $leave_status->used_leave }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('leave.update', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
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
                                    <label>Date</label>
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
                                    <select class="form-control" name="status" >
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
                                    <input type="text" class="form-control" name="approved_by" value="{{ $data->approved_by}}">

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