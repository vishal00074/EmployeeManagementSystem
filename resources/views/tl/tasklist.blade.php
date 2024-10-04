@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>{{ $project->project_name  }} Task Sheet</b></h4>
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
                            <a href="{{ url('employee/projects') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm" id="data">
                    <table class="table get_student_enrollment">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Billing Hours</th>
                                <th>Non Billing Hours</th>
                                <th>Date</th>
                                <th>Document</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                            <tr>
                                <td>
                                    @if ($task->employee_id)
                                    {{ $task->employeeName->name }}
                                    @endif
                                </td>
                                <td>{{ ucfirst($task->title) }}</td>
                                <td>{{ ucfirst($task->description) }}</td>
                                <td>{{ $task->billing_hours }}</td>
                                <td>{{ $task->non_billing_hours }}</td>
                                <td>{{ \Carbon\Carbon::parse($task->created_at)->isoFormat('D MMMM YYYY (h:mm:ss A)') }}</td>

                                <td>@foreach($task->documents_path as $key => $singledoc)
                                    <a href="{{ url($singledoc) }}" class="btn btn-success  btn-sm" target="_blank">Document</a>&nbsp;

                                    @endforeach

                                </td>
                                <td><a href="{{ url('employee/tl/task/reports') }}/{{ $task->id }}" class="btn btn-info btn-sm"> Report</a>&nbsp;
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
                {{ $tasks->links()  }}
            </div>

        </div>
    </div>
</div>
@endsection