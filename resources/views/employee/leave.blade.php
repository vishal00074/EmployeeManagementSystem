@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Leaves</b></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <!-- <a href="{{ url('employee/leave/apply') }}" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Apply For Leave
                        </a> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment table-bordered">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Leave Type</th>
                                <th>Applied Date</th>
                                <th>Approve By</th>
                                <th>Approve Date</th>
                                <th>Status</th>
                               
                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">


                            @forelse($leaves as $leave)
                            <tr>
                                <td>{{ $leave->leavetype->name ?? '' }}</td>
                                <td>{{ isset( $leave->date) ? \Carbon\Carbon::parse( $leave->date)->format('l, j F Y h:i A') : '' }}</td>
                                <td>{{ $leave->approved_by ?? '' }}</td>
                                <td>{{ isset( $leave->approved_at) ? \Carbon\Carbon::parse( $leave->approved_at)->format('l, j F Y h:i A') : '' }}</td>
                                @if($leave->status == 'pending')
                                <td style="background-color:#F8FF1E">{{ $leave->status ?? '' }}</td>
                                @elseif($leave->status =='approved')
                                <td style="background-color:#62FF1E">{{ $leave->status ?? '' }}</td>
                                @else
                                <td style="background-color:#FF3030">{{ $leave->status ?? '' }}</td>
                                @endif
                               
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan='7' align="center">No Data Found</td>
                            </tr>
                            @endforelse


                        </tfoot>
                    </table>
                    
                </div>
                <br>
                {{ $leaves->links()  }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="leave_model" align="center">
    <div class="modal-dialog  modal-lg" role="document">

        <div class="modal-content">
            <!-- <div class="modal-header d-inline">
                <center>
                    <h3 class="modal-title"><b><u>Update Today's Report</u></b></h3>
                </center>
            </div> -->
            <form name="AcceptLicense" id="AcceptLicense" action="{{ url('/employee/leave-apply') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 mt-4">
                            <i class="fa fa-upload mr-2"></i>Leave Type<br>
                            <select name="leave_type" class="form-control" id="leave_type" required>
                                <option value="">Select</option>
                                <option value="0">Full Day</option>
                                <option value="1">Half Day</option>
                                <option value="2">Short</option>
                            </select>

                        </div>
                        <div class="form-group col-md-12 mt-4">
                            <i class="fa fa-book mr-2"></i>Reason<br>
                            <textarea name="reason" class="form-control" id="editor"></textarea>
                        </div>

                        <div class="form-group col-md-12 mt-4">
                            <i class="fa fa-date mr-2"></i>Start Date<br>
                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" required>
                        </div>
                        <div class="form-group col-md-12 mt-4">
                            <i class="fa fa-date mr-2"></i>End Date<br>
                            <input type="datetime-local" class="form-control" name="end_date" id="end_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6" align="right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        <div class="form-group col-md-6" align="left">
                            <input type="submit" class="btn btn-primary" value="Submit" id="submitform">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
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