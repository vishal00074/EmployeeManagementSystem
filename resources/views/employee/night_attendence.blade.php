@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Monthly Attendence Sheet</b></h4>
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-6 col-md-6 mb-4" align="left">
							<button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button>
						</div> -->
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Sign IN Date</th>
                                <th>Sign Out Date</th>
                                <th>Total Hours</th>
                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">


                           @foreach($records as $record)
                            <tr>
                                <td>{{ isset($record->time_in) ? \Carbon\Carbon::parse($record->time_in)->addHours(11)->format('h:i A') : '' }}</td>
                                <td>{{ isset($record->time_out) ? \Carbon\Carbon::parse($record->time_out)->addHours(11)->format('h:i A') : '' }}</td>
                                <td>{{  $record->total_hours ?? '' }}</td>
                            </tr>
                            @endforeach
                            

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection