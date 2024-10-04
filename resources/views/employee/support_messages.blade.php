@extends('employee.layouts.app')
@section('content')
<!--  -->
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">

                <div class="row">
                    <!-- <div class="col-6 col-md-6 mb-4" align="left">
                        <button type="submit" data-toggle="modal" data-target="#project_model" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Update Report
                        </button>
                    </div> -->
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/support') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>


                <div class="d-flex" align="left">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Support Details</b></h4>
                    </div>
                </div>

           

                @if($supportDetails->isNotEmpty())
                    @foreach($supportDetails as $detail)
                        <div class="row mb-4" >
                            <div class="col-md-6">
                                @if($detail['recipient_id'] == 1)
                                    <b>You: </b> {{ $detail['message'] }} (<span class="highlight-date">{{ \Carbon\Carbon::parse($detail['created_at'])->isoFormat('Do MMMM YYYY [at] h:mm A') }}</span>)
                                    
                                    <!-- Display delete icon for employee's messages only -->
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('support.delete.message', ['id' => $detail['id']]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: none; font-size: 30px;border: none;" ><i class="fa fa-trash text-danger"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <b>Admin: </b> {{ $detail['message'] }} (<span class="highlight-date">{{ \Carbon\Carbon::parse($detail['created_at'])->isoFormat('Do MMMM YYYY [at] h:mm A') }}</span>)
                                @endif
                            </div>
                        </div> 
                    @endforeach
                @endif




                <form name="AcceptLicense" id="AcceptLicense" action="{{ url('/employee/support/add/message') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <?php $id = request()->route('id'); ?>
  
                       <input type="hidden" name="recipient_id" value="1">
                       <input type="hidden" name="support_id" value="{{ $id }}"> 
                       <input type="hidden" name="sender_id" value="{{ Auth::guard('employee')->user()->id }}">



                        <div class="row mb-3">
                            <label for="message" class="col-sm-3 col-form-label">Send Message</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3">
                            </textarea>
                            </div>
                        </div>


                            <div class="form-group col-md-6">
                                <input type="submit" class="btn btn-primary" value="Submit" id="submitform">
                            </div>

                 </form>

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



@endsection