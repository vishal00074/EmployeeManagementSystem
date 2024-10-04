@extends('employee.layouts.app')



@section('content')

@php
$employeeID = auth()->guard('employee')->user()->id;

$recipientCount = DB::table('support_messages')
->where('recipient_id', $employeeID)
->count();


$interviewcount = DB::table('interviews')->join('candidates', 'interviews.candidate_id', 'candidates.id')->where('interview_status', 'scheduled')->where('interviewer_name', auth()->guard('employee')->user()->id)->count();
$projectcount = DB::table('projects')->where('project_status', '<>', 'completed') ->whereRaw('FIND_IN_SET(?, projects.emp_name) > 0', [$employeeID])->count();

$now = Carbon\Carbon::now();  
$today_date =  $now->format('Y-m-d'); 

        $tasks = DB::table('project_tasks')
            ->join('projects', 'project_tasks.project_id', 'projects.id')
            ->join('employees', 'project_tasks.employee_id', 'employees.id')
            ->select('project_tasks.*')
            ->where('employees.id',  $employeeID)
            ->whereDate('project_tasks.date',  $today_date)
            ->count();

@endphp


    <div class="row table-box">
        <div class="col-md-4">
            <br><br><br>
            <div class="content">
                <h3>Interview & Support</h3>
                <h2></h2>
                <div class="abcd">
                    
                    <a href="{{ url('employee/interview') }}" class="interview-link">
                        <i class="fa fa-angle-right"></i>Interview @if($interviewcount > 0)<span class="count">{{ $interviewcount ?? 0 }}</span> @endif</a>

                    <a href="{{url('employee/support')}}" class="interview-link"><i class="fa fa-angle-right "></i> Support @if($recipientCount > 0)<span class="count">{{ $recipientCount ?? 0 }}</span> @endif</a>

                    <!-- <a href="{{url('employee/humanResource')}}"><i class="fa fa-angle-right"></i> HR Module </a> -->

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content">
                <h3>Employee Activity</h3>
                <h2></h2>
                <a href="{{url('employee/profile')}}"><i class="fa fa-angle-right"></i> Employee Profile</a>
                <!--<a id="UploadAggrement">Upload Aggrement</a>-->
                <a class="text-light interview-link" href="{{ url('employee/projects') }}">
                    <i class="fa fa-angle-right"></i>Task and Project Logs @if($projectcount > 0)<span class="count">{{ $projectcount ?? 0 }}</span> @endif
                </a>

                <a class="text-light interview-link" href="{{ url('employee/projects/task_list') }}">
                    <i class="fa fa-angle-right"></i>Task List @if($tasks > 0)<span class="count">{{ $tasks ?? 0 }}</span> @endif
                </a>

                @if(isset($role))
                @if($role->type == 'BM')
                <a class="text-light interview-link" href="{{ url('employee/bidder') }}">
                    <i class="fa fa-angle-right"></i>Bidder
                </a>
                @endif

                @if($role->type == 'HR')
                <a class="text-light interview-link" href="{{ url('employee/hr') }}">
                    <i class="fa fa-angle-right"></i>HR
                </a>
                @endif


                @if($role->type == 'TL')
                <a class="text-light interview-link" href="{{ url('employee/tl') }}">
                    <i class="fa fa-angle-right"></i>Team Leader
                </a>
                @endif

                @endif


            </div>
        </div>
        <div class="col-md-4">
            <br><br><br>
            <div class="content">
                <h3>Attendance & Leave</h3>
                <a href="{{ url('/employee/attendence/calender') }}" class="text-light"><i class="fa fa-angle-right"></i>Attendance </a>
                <a href="{{ url('/employee/attendence/history') }}" class="text-light"><i class="fa fa-angle-right"></i>Attendance History</a>
                <a href="{{ url('/employee/leave') }}" class="text-light"><i class="fa fa-angle-right"></i>My Leave</a>
                <a href="{{ url('employee/leave/apply') }}" class="text-light"><i class="fa fa-angle-right"></i>Apply for Leave</a>
            </div>
        </div>
    </div>

    @endsection

    @section('script')
    <script src="{{asset('assets/franchisee/scripts/register.js')}}?{{time()}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    @endsection