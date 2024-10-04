@extends('admin.leave.app')
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
                   <!--  <div class="col-6 col-md-6 mb-4" align="left">
                        <a href="{{ url('employee/leave/apply') }}" class="btn btn-info btn-sm">
                            <i class="icon-copy4 mr-2"></i>Apply For Leave
                        </a>
                    </div> -->
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a class="btn btn-success" href="{{ url('admin/leave') }}">Back </a>

                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Leave Type</th>
                                <th>Approve By</th>
                                <th>Approve Date</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">


                            <?php foreach($leaves as $leave) { ?>
                            <tr>
                                <td>{{ $leave->leave_type ?? '' }}</td>
                                <td>{{ $leave->approved_by ?? '' }}</td>
                                <td>{{ isset( $leave->approved_at) ? \Carbon\Carbon::parse( $leave->assign_date)->format('l, j F Y h:i A') : '' }}</td>
                                @if($leave->status == 'pending')
                                <td style="background-color:yellow">{{ $leave->status ?? '' }}</td>
                                @elseif($leave->status =='approved')
                                <td style="background-color:green">{{ $leave->status ?? '' }}</td>
                                @else
                                <td style="background-color:red">{{ $leave->status ?? '' }}</td>
                                @endif
                                <td>{{ isset( $leave->start_date) ? \Carbon\Carbon::parse( $leave->start_date)->format('l, j F Y h:i A') : '' }}</td>
                                <td>{{ isset( $leave->end_date) ? \Carbon\Carbon::parse( $leave->end_date)->format('l, j F Y h:i A') : '' }}</td>

                            </tr>
                            <?php } ?>


                        </tfoot>
                    </table>
                </div>
            </div>
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