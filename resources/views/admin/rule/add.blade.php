@extends('admin.rule.app')


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
			    <a class="btn btn-success" href="{{ url('admin/rule') }}">Back</a>
            </div>
        </div>
                
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="{{ route('rule.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employee Name</label>
                                        <select class="form-control" name="employee_id" id="employee_id">
                                            <option value="">Select</option>
                                            @foreach($employee as $employees)
                                            <option value="{{ $employees->id }}">{{ $employees->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('employee_id'))
                                        <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                        @endif
                                    </div>
                              </div>

                             <div class="col-md-6">
                                  <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="type">
                                            <option value="">Select</option>
                                            <option value="HR">HR</option>
                                            <option value="BM">Business Management</option>
                                            <option value="TL">Team Leader</option>
                                        </select>
                                        @if ($errors->has('type'))
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
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

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

