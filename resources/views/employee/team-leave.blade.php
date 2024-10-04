@extends('employee.layouts.app')
@section('content')
<!--  -->
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4"><b>Team Member Leave List</b></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">

                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>


                <br>
                <!--  -->
                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Employee Name</th>
                                <th>Leave Type</th>
                                <th>Applied Date</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">


                            @forelse($teammember_leave as $leave)
                            <tr>
                                <td>{{ $leave->emp_name ?? '' }}</td>
                                <td>{{ $leave->leave_type_name ?? '' }}</td>
                                <td>{{ isset( $leave->date) ? \Carbon\Carbon::parse( $leave->date)->format('l, j F Y h:i A') : '' }}</td>

                                @if($leave->status == 'pending')
                                <td> <a href="{{ url('employee/team/view') }}/{{ $leave->id }}" class="btn btn-success">
                                        Detail
                                    </a></td>
                                @endif
                                @empty
                                <td colspan='5' align='center'>No Data found</td>
                            </tr>
                            @endforelse
                        </tfoot>
                    </table>
                    {!! $teammember_leave->links() !!}
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