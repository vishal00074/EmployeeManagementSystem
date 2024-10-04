@extends('employee.layouts.app')
@section('css')
<style>
    .image-previews {
        gap: 10px;
        /* Space between images */
    }

    .preview-container {
        margin-bottom: 10px;
        /* Space between image previews */
    }

    .preview-container img {
        width: 100px;
        /* Set image width */
    }

    .delete-preview {
        cursor: pointer;
        color: red;
        font-weight: bold;
        font-size: 20px;
    }
</style>
@endsection
@section('content')
<!--  -->
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                @php
                $is_teamLeader = TeamLeader();
                @endphp

                <div class="row">

                    <div class="col-6 col-md-6 mb-4" align="right">

                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/projects') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>

                </div>
                <div class="d-flex" align="left">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Project Details</b></h4>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Project Name:</b> {{ $projects->project_name ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Assign By:</b> {{ $projects->assign_by_name ?? ''  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Department:</b> {{ $projects->department_name ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Upwrok Profile:</b> {{ $projects->upwork_name ?? ''  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Client Name:</b> {{ $projects->client_name ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Billing Hours:</b>{{ $projects->billing_hours ?? ''  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Project Status:</b> {{ $projects->project_status ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Date:</b> {{ $projects->assign_date ? Carbon\Carbon::parse($projects->assign_date)->format('l, j F Y') : '';  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Project Description : </b> {{ $projects->project_description ?? ''  }}
                    </div>

                </div>
                <hr>
                <br>


                <div class="col-sm-12 p-0">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Task History</b></h4>
                    </div>
                    <div class="table-responsive">
                        <table id="CItemDetails" width="100%" style="background: #FFFFFF; font-family: Tahoma; font-size: 14" border="1" cellpadding="4" cellspacing="0" bordercolorlight="#CCCCCC" bordercolor="#CCCCCC" bordercolordark="#FFFFFF" align="center">
                            <tbody>
                                <tr style="height: 30px">
                                    <td colspan="8" style="background: #009999;text-align:center;">
                                        <font color="#FFFFFF"><b>Project Task</b></font>
                                    </td>
                                </tr>
                                <tr bgcolor="#009999">
                                    <td width="55%" id="rkSLNo"><b>
                                            <font color="#FFFFFF">Title </font>
                                        </b></td>
                                    <td width="15%" id="rkItemCode"><b>
                                            <font color="#FFFFFF">Billing Hours</font>
                                        </b></td>
                                    <td width="15%" id="rkItemName"><b>
                                            <font color="#FFFFFF">Non Billing hours</font>
                                        </b></td>
                                    <td width="15%" id="rkOrderQty"><b>
                                            <font color="#FFFFFF">Date</font>
                                        </b></td>
                                    <td width="15%" id="rkOrderQty"><b>
                                            <font color="#FFFFFF">Documents</font>
                                        </b></td>
                                    <td width="15%" id="rkOrderQty"><b>
                                            <font color="#FFFFFF">Action</font>
                                        </b></td>

                                    <!-- <td width="20%" id="rkOrderFor"><b>
                                            <font color="#FFFFFF">Action</font>
                                        </b></td> -->
                                </tr>
                                <?php $i = 1 ?>
                                @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->billing_hours }}</td>
                                    <td>{{ $task->non_billing_hours }}</td>
                                    <td>{{ $task->date ? Carbon\Carbon::parse($task->date)->format('l, j F Y') : '';  }}</td>
                                    <td>@foreach($task->documents_path as $key => $singledoc)
                                        <a href="{{ url($singledoc) }}" class="btn btn-success" target="_blank">Document</a>&nbsp;
                                        @endforeach
                                    </td>
                                    <td><a class="btn btn-info" id="view_task" href="{{ url('employee/view/task') }}/{{ $task->id }}" data-id="{{ $task->id }}">View</a>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No Data Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>
                <br>
                <hr>
                @if($is_teamLeader )
                <div class="col-sm-12 p-0 mt-3  add_task">
                    <form name="task" id="task" action="{{ route('task.assign.tl')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $projects->id ?? '' }}">

                        <div class="row mb-3">
                            <label for="feedback" class="col-sm-3 col-form-label">Employee</label>
                            <div class="col-sm-9">
                                <select name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id">
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
                @endif
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




<script type="text/javascript">
    $(document).ready(function() {
        if ($("#task").length > 0) {
            $("#task").validate({
                rules: {
                    // FranchiseeCode: 'required',
                    employee_id: 'required',
                    description: 'required',
                    title: 'required',
                    billing_hours: 'required',

                },
                messages: {
                    // FranchiseeCode: "Franchisee Code field is required.",
                    employee_id: "employee field is required.",
                    description: "description field is required.",
                    title: "title field is required.",
                    billing_hours: "billing hours field is required.",

                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>

<script>
    // Function to display image previews
    function displayImagePreview(input) {
        if (input.files && input.files.length > 0) {
            $('#imagePreviews').html(''); // Clear previous previews
            for (let i = 0; i < input.files.length; i++) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let imageHtml = '<div class="preview-container">' +
                        '<img src="' + e.target.result + '" class="img-thumbnail" width="100">' +
                        '<span class="delete-preview">&times;</span>' +
                        '</div>';
                    $('#imagePreviews').append(imageHtml);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    // Event listener for file input change
    $('#documents').on('change', function() {
        displayImagePreview(this);
    });

    // Event listener for delete button click
    $('#imagePreviews').on('click', '.delete-preview', function() {
        $(this).parent('.preview-container').remove();
    });
</script>



@endsection