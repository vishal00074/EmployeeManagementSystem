@extends('admin.support.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Support Messages</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/support') }}">Back</a>
            </div>
        </div>
        
        <div class="card-body custom-card-body">
            <div class="row">
                <div class="col-md-12">
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

                                <b>Employee ({{ $employeeName }}):</b> {{ $detail['message'] }} (<span class="highlight-date">{{ \Carbon\Carbon::parse($detail['created_at'])->isoFormat('Do MMMM YYYY [at] h:mm A') }}</span>)

                                   
                                    
                                    <!-- Display delete icon for employee's messages only -->
                                    
                                @else


  <b>You: </b> {{ $detail['message'] }} (<span class="highlight-date">{{ \Carbon\Carbon::parse($detail['created_at'])->isoFormat('Do MMMM YYYY [at] h:mm A') }}</span>) 
                                       
<div class="btn-group" role="group">
                                        <form action="{{ route('support.delete.message.admin', ['id' => $detail['id']]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm delete-btn"><i class="fa fa-trash text-danger"></i></button>
                                        </form>
                                    </div>
                                  
                                @endif
                            </div>
                        </div> 
                    @endforeach
                @endif




                    <form action="{{ route('support.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $recipientId }}">
                        <input type="hidden" name="support_id" value="{{ $supportId }}">
                        <input type="hidden" name="sender_id" value="{{ Auth::guard('admin')->user()->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="subject" value="{{$data->subject }}" readonly> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" readonly>{{$data->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea> 
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary custom-btn">Submit <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <br>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection

@section('style')
<style>
    .custom-btn {
        margin-top: 10px;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
    }

    .custom-btn:hover {
        background-color: #45a049;
    }

    .highlight-date {
        color: blue; /* or any other color you prefer */
        font-weight: bold; /* optionally make the date bold */
    }

body .custom-card-body .delete-btn {
    background: transparent;
    border: 0px;
    font-size: 30px;
}

</style>
@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>


@endsection
