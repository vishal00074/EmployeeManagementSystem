@extends('admin.leave.app')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
@endsection

@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Assign Leave</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('leave.assign') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" name="start_date">

                                    @if ($errors->has('start_date'))
                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" name="end_date">

                                    @if ($errors->has('end_date'))
                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Leave</label>
                                    <select class="form-control" name="leave_id">
                                        <option value="">Select</option>
                                        @foreach($leaves as $leave)
                                        <option value="{{ $leave->id }}">{{ $leave->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('leave_id'))
                                    <span class="text-danger">{{ $errors->first('leave_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Employee</label>
                                    <select class="form-control" name="employee_id">
                                        <option value="">Select</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('employee_id'))
                                    <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                    @endif
                                </div>
                            </div>


                           



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Days</label>
                                    <input type="number" class="form-control" name="days">

                                    @if ($errors->has('days'))
                                    <span class="text-danger">{{ $errors->first('days') }}</span>
                                    @endif
                                </div>
                            </div>






                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>
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