@extends('admin.leave.app')


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
			    <a class="btn btn-success" href="{{ url('admin/leave') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                    <form  action="{{ route('leave.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                        

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <select class="form-control" name="emp_id">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('emp_id'))
                                        <span class="text-danger">{{ $errors->first('emp_id') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Leave Type</label>
                                    <select class="form-control" name="leave_type">
                                        <option value="">Leave Type</option> 
                                        <option value="2">Short Leave</option> 
                                        <option value="1 ">Half Day</option> 
                                        <option value="0">Full Day</option> 

                                    </select>    
                                      @if ($errors->has('leave_type'))
                                        <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                                    @endif
                                </div>
                            </div>
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
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                         <option value="">Select</option> 
                                        <option value="pending">Pending</option> 
                                        <option value="approved">Approved</option> 
                                        <option value="rejected">Rejected</option> 
                                    </select>    
                                      @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Approved By</label>
                                     <input type="text" class="form-control" name="approved_by"> 

                                      @if ($errors->has('approved_by'))
                                        <span class="text-danger">{{ $errors->first('approved_by') }}</span>
                                    @endif
                                </div>
                            </div>


                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Approved At</label>
                                    <input type="datetime-local" class="form-control" name="approved_at"> 

                                    @if ($errors->has('approved_at'))
                                        <span class="text-danger">{{ $errors->first('approved_at') }}</span>
                                    @endif
                                </div>
                            </div>

                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Reason</label>
                                    <textarea type="text" class="form-control" id="editor" name="reason">
                                       
                                    </textarea>
                                    @if ($errors->has('reason'))
                                        <span class="text-danger">{{ $errors->first('reason') }}</span>
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
