@extends('admin.shift.app')


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
                <a class="btn btn-success" href="{{ url('admin/shift') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('shift.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift Type</label>
                                    <input type="text" class="form-control" name="type">
                                    @if ($errors->has('type'))
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Timing</label>
                                    <input type="text" class="form-control" name="timing" placeholder="9:30 AM to 6:30 PM">
                                    @if ($errors->has('timing'))
                                    <span class="text-danger">{{ $errors->first('timing') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Time IN</label>
                                    <input type="time" class="form-control" name="time_in">
                                    @if ($errors->has('time_in'))
                                    <span class="text-danger">{{ $errors->first('time_in') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Time Out</label>
                                    <input type="time" class="form-control" name="time_out">
                                    @if ($errors->has('time_out'))
                                    <span class="text-danger">{{ $errors->first('time_out') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subtract Hours</label>
                                    <input type="number" class="form-control" name="less_hours">
                                    @if ($errors->has('less_hours'))
                                    <span class="text-danger">{{ $errors->first('less_hours') }}</span>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection