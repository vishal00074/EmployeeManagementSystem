@extends('admin.project.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Update Details</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/project/task-view/') }}/{{ $id }}">Back</a>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                <form name="task" id="task" action="{{ route('task.assign', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $id ?? '' }}">

                        <div class="row mb-3">
                            <label for="feedback" class="col-sm-3 col-form-label">Employee</label>
                            <div class="col-sm-9">
                                <select name="employee_id"   class="form-control @error('title') is-invalid @enderror" id="employee_id">
                                    <option value="">Select</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id  }}">{{ $employee->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="feedback" class="col-sm-3 col-form-label">Task</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">
                            </textarea>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="billing_hours" class="col-sm-3 col-form-label">Billing Hours</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('billing_hours') is-invalid @enderror" id="billing_hours" name="billing_hours">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="non_billing_hours" class="col-sm-3 col-form-label">Non Billing Hours</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('non_billing_hours') is-invalid @enderror" id="non_billing_hours" name="non_billing_hours">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="screenshots" class="col-sm-3 col-form-label">Upload Documents</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control @error('documents') is-invalid @enderror" id="documents" name="documents[]" multiple>
                            </div>
                        </div>

                        <div id="imagePreviews"></div>


                        <div class="row">
                          
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-primary" value="Submit" id="submitform">
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
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($("#task").length > 0) {
            $("#task").validate({
                rules: {
                    employee_id: 'required',
                    title: 'required',
                    description: 'required',
                    date: 'required',
                },
                messages: {
                    employee_id: "Employee field is required.",
                    title: "Title field is required.",
                    description: "description field is required.",
                    date: "Date  field is required.",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }

    });
</script>
@endsection