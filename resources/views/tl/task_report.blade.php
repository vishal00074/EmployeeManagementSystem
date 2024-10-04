@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>{{ $project->title  }}</b></h4>
                    </div>
                </div>



                <div class="row">
                    <div class="col-6 col-md-6 mb-4" align="left">
                        <!-- <button type="submit" class="btn btn-info btn-sm">
								<a href="javascript:void(0)" class="text-white print"><i class="icon-copy4 mr-2"></i>Print</a>
							</button> -->
                    </div>
                    <div class="col-6 col-md-6 mb-4" align="right">
                        <button type="button" class="btn btn-success btn-sm">
                            <a href="{{ url('employee/tl/project/task/') }}/{{  $project->project_id }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Subject</th>
                                <th>Billing Hours</th>
                                <th>Non billing hours</th>
                                <th>Message</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($taskreports as $report)
                            <tr>
                                <td>{{ ucfirst($report->emp_name) }}</td>
                                <td>{{ ucfirst($report->subject) }}</td>
                                <td>{{ $report->task_billing_hours }}</td>
                                <td>{{ $report->task_non_billing_hours }}</td>
                                <td>{{ ucfirst($report->message) }}</td>

                                <td>@foreach($report->documents as $key => $singledoc)
                                    @if(!empty( $singledoc))
                                    <a href="{{ url($singledoc) }}" class="btn btn-success  btn-sm" target="_blank">Document</a>&nbsp;
                                    @endif
                                    @endforeach
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <br>
                {{ $taskreports->links()  }}
            </div>

        </div>
    </div>
</div>
@endsection