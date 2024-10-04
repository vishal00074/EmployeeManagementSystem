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
                   <div class="col-6 col-md-6 mb-4" align="left">
							 <!-- <button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button>-->
						</div> 
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm table-bordered" id="data">
                    <table class="table get_student_enrollment">
                        <thead class="table-dark table-sm">
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Sign IN</th>
                                <th>Sign Out</th>
                                <th>Total Hours</th>

                            </tr>
                        </thead>
                        <tfoot class="table-secondary" id="table_status">
                            @foreach($records as $record)
                            <tr>
                                <td>{{ $record->date ?? '' }}</td>
                                <td>{{ $record->day ?? ''}}</td>
                                <td>{{ $record->time_in ?? '' }}</td>
                                <td>{{ $record->time_out ?? '' }}</td>
                                <td>{{ $record->total_hours ?? '' }}</td>
                            </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
                <br>
                {{ $records->links() }}
            </div>
            
        </div>
    </div>
</div>
@endsection