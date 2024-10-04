@extends('employee.layouts.app')
@section('content')
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
                            <a href="{{ url('employee/') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>

                </div>

                
                <hr>
                <br>


                <div class="col-sm-12 p-0">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Your Enquiry</b></h4>
                    </div>
                    <div class="table-responsive">
                        <table id="CItemDetails" width="100%" style="background: #FFFFFF; font-family: Tahoma; font-size: 14" border="1" cellpadding="4" cellspacing="0" bordercolorlight="#CCCCCC" bordercolor="#CCCCCC" bordercolordark="#FFFFFF" align="center">
                            <tbody>
                                <tr style="height: 30px">
                                    <td colspan="8" style="background: #009999;text-align:center;">
                                        <font color="#FFFFFF"><b>Enquiry Detail</b></font>
                                    </td>
                                </tr>
                                <tr bgcolor="#009999">
                                    <td width="15%" id="rkSLNo"><b>
                                            <font color="#FFFFFF">Title</font>
                                        </b></td>
                                    <td width="50%" id="rkItemCode"><b>
                                            <font color="#FFFFFF">Description</font>
                                        </b></td>
                                    <td width="15%" id="rkItemName"><b>
                                            <font color="#FFFFFF">Ticket Status</font>
                                        </b></td>

                                    <td width="20%" id="rkItemName"><b>
                                            <font color="#FFFFFF">view message</font>
                                        </b></td> 
                                    <td width="20%" id="rkItemName"><b>
                                            <font color="#FFFFFF">Action</font>
                                        </b></td>    
                                    

                                    <!-- <td width="20%" id="rkOrderFor"><b>
                                            <font color="#FFFFFF">Action</font>
                                        </b></td> -->
                                </tr>
                                <?php $i = 1 ?>
                                @forelse ($support as $task)
                                <tr>
                                    <td>{{ $task->subject }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td style="color: red;">{{ ucwords($task->status) }}</td>

                                     <td>
                                        <a href="{{ url('employee/support/message', ['id' => $task->id]) }}">
                                            <button type="button" class="btn btn-primary btn-sm">View Message</button>
                                        </a>
                                    </td>
                                     <td>
                                            <form action="{{ route('support.delete', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-post">Delete</button>
                                            </form>
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
         
                <div class="col-sm-12 p-0 mt-3">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Support (Generate Ticket)</b></h4>
                    </div>
                    <form name="AcceptLicense" id="AcceptLicense" action="{{ url('/employee/support/add') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="row mb-3">
                            <label for="feedback" class="col-sm-3 col-form-label">Subject</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">
                            </textarea>
                            </div>
                        </div>


                            <div class="form-group col-md-6">
                                <input type="submit" class="btn btn-primary" value="Submit" id="submitform">
                            </div>
                        </div>

                    </form>
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

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".employeeDetail").length > 0) {
            $(".employeeDetail").validate({
                rules: {
                    // FranchiseeCode: 'required',
                    FranchiseeName: 'required',
                    FranchiseeType: 'required',
                    ProgramName: 'required',
                    ContactPerson: 'required',
                    PhoneNo: 'required',
                    MobileNo: 'required',
                    EmailID: 'required',
                    Usr_Code: 'required',
                    Address: 'required'
                },
                messages: {
                    // FranchiseeCode: "Franchisee Code field is required.",
                    FranchiseeName: "Franchisee name field is required.",
                    FranchiseeType: "Franchisee name field is required.",
                    ProgramName: "Program name field is required.",
                    ContactPerson: "Contact person field is required.",
                    PhoneNo: "Phone number field is required.",
                    MobileNo: "Mobile number field is required.",
                    EmailID: "Email field is required.",
                    Usr_Code: "User code field is required.",
                    Address: "Address field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteButtons = document.querySelectorAll('.delete-post');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this post?')) {
                    // User confirmed, submit the form
                    this.closest('form').submit();
                } else {
                    // User canceled, do nothing
                }
            });
        });
    });
</script>



@endsection