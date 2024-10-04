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

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <!-- <button type="submit" data-toggle="modal" data-target="#project_model" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Update Report
                        </button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/project/detail/') }}/{{ $task->project_id }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>

                </div>
                <div class="d-flex" align="left">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Task Details</b></h4>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Task:</b> {{ $task->title ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Description:</b> {{ $task->description ?? ''  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Billing Hours:</b> {{ $task->billing_hours ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Non Billing Hours:</b> {{ $task->non_billing_hours ?? ''  }}
                    </div>
                </div>



                <div class="row mb-4">

                    <div class="col-md-6">
                        <b>Date:</b> {{ $task->date ? Carbon\Carbon::parse($task->date)->format('l, j F Y') : '';  }}
                    </div>
                </div>


                <hr>
                <br>


                <div class="col-sm-12 p-0">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Task Records</b></h4>
                    </div>
                    <div class="table-responsive">
                        <table id="CItemDetails" width="100%" style="background: #FFFFFF; font-family: Tahoma; font-size: 14" border="1" cellpadding="4" cellspacing="0" bordercolorlight="#CCCCCC" bordercolor="#CCCCCC" bordercolordark="#FFFFFF" align="center">
                            <tbody>
                                <tr style="height: 30px">
                                    <td colspan="8" style="background: #009999;text-align:center;">
                                        <font color="#FFFFFF"><b>Task Report</b></font>
                                    </td>
                                </tr>
                                <tr bgcolor="#009999">
                                    <td width="55%" id="rkSLNo"><b>
                                            <font color="#FFFFFF">Subject </font>
                                        </b></td>
                                    <td width="15%" id="rkItemCode"><b>
                                            <font color="#FFFFFF">Billing Hours</font>
                                        </b></td>
                                    <td width="15%" id="rkItemName"><b>
                                            <font color="#FFFFFF">Non Billing hours</font>
                                        </b></td>

                                    <td width="15%" id="rkOrderQty"><b>
                                            <font color="#FFFFFF">Documents</font>
                                        </b></td>


                                 
                                </tr>
                                <?php $i = 1 ?>
                                @forelse ($taskreport as $report)
                                <tr>
                                    <td>{{ $report->subject ?? '' }}</td>
                                    <td>{{ $report->task_billing_hours ?? '' }}</td>
                                    <td>{{ $report->task_non_billing_hours ?? '' }}</td>
                                    
                                    <td>@foreach($report->documents as $key => $singledoc)
                                    @if(!empty($singledoc))
                                   <a href="{{ url($singledoc) }}" class="btn btn-success" target="_blank">Document</a><br><br>
                                   @endif
                                        @endforeach
                                    </td>
                                  
                                   
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
                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <button type="submit" id="report_model" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Add Report
                        </button>
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">

                    </div>

                </div>
                <div class="col-sm-12 p-0 mt-3 report-form">

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

<script>
    $(document).ready(function() {
        $('#report_model').on('click', function() {
            console.log('okay');
            var taskID = <?php echo $id ?>;
            var form = $('.report-form');
            form.empty();
            var report = `<div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('submit.report') }}"  method="post" id="task_report" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="task_id" id="task_id" value="` + taskID + `" required>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Add subject" required>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Billing Hours</label>
                                            <input type="text" class="form-control" id="task_billing_hours" name="task_billing_hours">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Non Billing Hours</label>
                                            <input type="text" class="form-control" id="task_non_billing_hours" name="task_non_billing_hours">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Document</label>
                                            <input type="file" class="form-control" id="documents" name="documents[]"  multiple>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea type="text" class="form-control" id="message" name="message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <input type="submit" class="btn btn-primary" name="submit_form" id="submit_form" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>`;
            form.append(report);
        });
        
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