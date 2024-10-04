@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Add Lead</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <!-- <button type="submit" class="btn btn-info btn-sm">
                            <a href="{{ url('employee/hr/job/add')  }}" class="text-white print"><i class="icon-copy4 mr-2"></i>Add Job</a>
                        </button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/leads/') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="addForm">Add</button>
                    </div>
                </div> -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('leads.save') }}" method="post" class="canidate" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" class="form-control" name="url" id="url" placeholder="Add Bid URl" required>
                                        </div>
                                    </div>


                                    @php

                                    $agencies = DB::table('agencies')->select('*')->get();

                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Agency</label>
                                            <select class="form-control" id="agency_id" name="agency_id" required>
                                                <option value="">Select</option>
                                                @foreach($agencies as $agency)
                                                <option value="{{ $agency->id  }}">{{ $agency->name  }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Upwork</label>
                                            <select class="form-control" id="upwork_id" name="upwork_id" required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bid url</label>
                                            <input type="text" class="form-control" id="bid_url" name="bid_url">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <option value="open">open</option>
                                                    <option value="converted">converted</option>
                                                    <option value="discard">discard</option>
                                            </select>
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
    </div>
</div>
@endsection


@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#agency_id').on('change', function() {
            console.log('okay');
            var agency_id = $('#agency_id').val();
            var upwork_id = $('#upwork_id');

            $.ajax({
                url: "{{ url('employee/ajax/upwork_id') }}",
                method: 'Get',
                data: {
                    agency_id: agency_id
                },
                success: function(response) {
                    result = response.data
                    upwork_id.empty();
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < response.data.length; i++) {
                        data += '<option value="' + response.data[i].id + '">' + response.data[i].name + '</option>';
                    }
                    upwork_id.append(data);

                    console.log('Data sent successfully!', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".canidate").length > 0) {
            $(".canidate").validate({
                rules: {
                    url: 'required',
                    agency_id: 'required',
                    upwork_id: 'required',
                    client_name: 'required',
                    remarks: 'required',
                    
                    status:'required'
                },
                messages: {
                    url: "url field is required.",
                    agency_id: "Agency field is required.",
                    upwork_id: "upwork field is required.",
                    client_name: "client name field is required.",
                    remarks: "remarks field is required.",
                    status:"status field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }

    });
</script>
@endsection