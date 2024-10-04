<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AttendenceController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\HumanResourceController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageLengthController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\EmployeeReportController;
use App\Http\Controllers\Admin\RevenueController;





use App\Http\Controllers\employee\AuthEmployeeController;
use App\Http\Controllers\employee\EmployeeDashboardController;
use App\Http\Controllers\employee\EmployeeAttendanceController;
use App\Http\Controllers\employee\EmployeeProjectController;
use App\Http\Controllers\employee\EmployeeLeaveController;
use App\Http\Controllers\employee\EmployeeInterviewController;
use App\Http\Controllers\employee\EmployeeSupportController;




use App\Http\Controllers\DesignationController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\UpworkController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;



use App\Http\Controllers\Bidder\BidderController;
use App\Http\Controllers\Bidder\LeadController;
use App\Http\Controllers\Bidder\ContractController;



use App\Http\Controllers\HR\HRController;
use App\Http\Controllers\HR\HRJobController;
use App\Http\Controllers\HR\HRCandidateController;
use App\Http\Controllers\HR\HRInterviewController;
use App\Http\Controllers\HR\HRAttandenceRecord;

use App\Http\Controllers\TL\TeamLeaderController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::patch('/fcm-token', [AuthEmployeeController::class, 'updateToken'])->name('fcmToken');

Route::get('/', function(){
    return redirect('/employee');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

    Route::group(['middleware' => 'adminauth'], function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('adminDashboard');

        Route::get('/logout', [AdminAuthController::class, 'adminLogout']);



        //____EmployeeReport Routes 
        Route::get('/employee/reports', [EmployeeReportController::class, 'EmployeeReport']); 
        Route::get('/employee/report/detail/{id}', [EmployeeReportController::class, 'EmployeeReportDetail']); 
        Route::get('/employee/task/report/{id}', [EmployeeReportController::class, 'EmployeeTaskReport']); 

        

        //_____Department Routes
        Route::get('/department', [DepartmentController::class, 'Department']);
        Route::get('/department/add', [DepartmentController::class, 'AddDepartment']);
        Route::get('/department/edit/{id}', [DepartmentController::class, 'EditDepartment']);
        Route::post('/department/add', [DepartmentController::class, 'SaveDepartment'])->name('department.save');
        Route::post('/department/update/{id}', [DepartmentController::class, 'UpdateDepartment'])->name('department.update');
        Route::delete('/department_delete/{id}', [DepartmentController::class, 'DeleteDepartment']);


        //_____ Designation Routes
        Route::get('/designation', [DesignationController::class, 'Designation']);
        Route::get('/designation/add', [DesignationController::class, 'StoreDesignation']);
        Route::post('/designation/add', [DesignationController::class, 'SaveDesignation'])->name('designation.save');
        Route::get('/designation/edit/{id}', [DesignationController::class, 'EditDesignation']);
        Route::post('/designation/update/{id}', [DesignationController::class, 'UpdateDesignation'])->name('designation.update');
        Route::delete('/designation_delete/{id}', [DesignationController::class, 'DeleteDesignation']);


        //_____ Agency Routes
        Route::get('/agency', [AgencyController::class, 'Agency']);
        Route::get('/agency/add', [AgencyController::class, 'StoreAgency']);
        Route::post('/agency/add', [AgencyController::class, 'SaveAgency'])->name('agency.save');
        Route::get('/agency/edit/{id}', [AgencyController::class, 'EditAgency']);
        Route::post('/agency/update/{id}', [AgencyController::class, 'UpdateAgency'])->name('agency.update');
        Route::delete('/agency_delete/{id}', [AgencyController::class, 'DeleteAgency']);


        //____ Upwork Routes
        Route::get('/upwork', [UpworkController::class, 'Upwork']);
        Route::get('/upwork/add', [UpworkController::class, 'StoreUpwork']);
        Route::post('/upwork/add', [UpworkController::class, 'SaveUpwork'])->name('upwork.save');
        Route::get('/upwork/edit/{id}', [UpworkController::class, 'EditUpwork']);
        Route::post('/upwork/update/{id}', [UpworkController::class, 'UpdateUpwork'])->name('upwork.update');
        Route::delete('/upwork_delete/{id}', [UpworkController::class, 'DeleteUpwork']);


        //___ Shift Routes 
        Route::get('/shift', [ShiftController::class, 'Shift']);
        Route::get('/shift/add', [ShiftController::class, 'StoreShift']);
        Route::post('/shift/add', [ShiftController::class, 'SaveShift'])->name('shift.save');
        Route::get('/shift/edit/{id}', [ShiftController::class, 'EditShift']);
        Route::post('/shift/update/{id}', [ShiftController::class, 'UpdateShift'])->name('shift.update');
        Route::delete('/shift_delete/{id}', [ShiftController::class, 'DeleteShift']);


        //___ Assign Rules Routes 
        Route::get('/rule', [RuleController::class, 'Rule']);
        Route::get('/rule/add', [RuleController::class, 'StoreRule']);
        Route::post('/rule/add', [RuleController::class, 'SaveRule'])->name('rule.save');
        Route::get('/rule/edit/{id}', [RuleController::class, 'EditRule']);
        Route::post('/rule/update/{id}', [RuleController::class, 'UpdateRule'])->name('rule.update');
        Route::delete('/rule_delete/{id}', [RuleController::class, 'DeleteRule']);



        //_____ Employee Routes
        Route::get('/employee', [EmployeeController::class, 'Employee']);
        Route::get('/employee/add', [EmployeeController::class, 'StoreEmployee']);
        Route::post('/employee/add', [EmployeeController::class, 'SaveEmployee'])->name('employee.save');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'EditEmployee']);
        Route::post('/employee/update/{id}', [EmployeeController::class, 'UpdateEmployee'])->name('employee.update');
        Route::delete('/employee_delete/{id}', [EmployeeController::class, 'DeleteEmployee']);

        // Employee Ajax Routes
        Route::post('/department_employee', [EmployeeController::class, 'DepartmentEmployee']);

        Route::get('/project', [ProjectController::class, 'Project']);
        Route::get('/project/add', [ProjectController::class, 'AddProject']);
        Route::get('/project/edit/{id}', [ProjectController::class, 'EditProject']);
        Route::post('/project/add', [ProjectController::class, 'SaveProjects'])->name('project.save');
        Route::post('/project/update/{id}', [ProjectController::class, 'UpdateProject'])->name('project.update');
        Route::delete('/project_delete/{id}', [ProjectController::class, 'DeleteProject']);
        Route::get('/project/task-view/{id}', [ProjectController::class, 'task']);

        Route::get('project/task/add/{id}', [AdminTaskController::class, 'AddTask']);
        Route::post('project/task/add/{id}', [AdminTaskController::class, 'SaveTask'])->name('task.assign');
        Route::delete('task/delete/{id}', [AdminTaskController::class, 'TaskDelete']);
        Route::get('task/reports/{id}', [AdminTaskController::class, 'TaskReport']);
        Route::get('task/edit/{id}', [AdminTaskController::class, 'EditTask']);
        Route::post('task/edit/{id}', [AdminTaskController::class, 'UpdateTask'])->name('task.assign.edit');;

        //Revenue Routes
        Route::get('project/revenue', [RevenueController::class, 'RevenueIndex']);
        Route::get('/graph', [RevenueController::class, 'Graph']);


        



        //_____ Attendence Routes
        Route::get('/attendence', [AttendenceController::class, 'Attendence']);
        Route::get('/attendence/night', [AttendenceController::class, 'NightAttendence']);
        Route::get('/attendence/monthly/{id}', [AttendenceController::class, 'MonthlyAttendence']);
        Route::get('/attendence/night/monthly/{id}', [AttendenceController::class, 'NightMonthlyAttendence']);
        Route::get('/attendence/records/{id}', [AttendenceController::class, 'AllAttendenceRecords']);
        Route::get('/attendence/nightrecords/{id}', [AttendenceController::class, 'AllNightAttendenceRecords']);
        Route::get('/attendence/calender/{id}', [AttendenceController::class, 'AttendenceCalender']);
        Route::get('/attendence/edit', [AttendenceController::class, 'AttendenceEdit']);
        Route::get('/attendence/records', [AttendenceController::class, 'AttendenceRecords'])->name('admin.attendance.records');

        Route::get('/attendance/pdf/records', [AttendenceController::class, 'AttendencePDFRecord']);
        Route::get('/ajax-attendance-records', [AttendenceController::class, 'AjaxAttendance']);


        Route::get('/attendance/report', [AttendenceController::class, 'AttendanceReport']);
        Route::get('/attendance/report/monthly', [AttendenceController::class, 'AttendanceReportMonthly'])->name('monthly.attendance');

        //___ Document Routes 
        Route::get('attendance/pdf/{date}/{enddate}/{employee_id}', [DocumentController::class, 'AttendencePDFDocument']);
        Route::get('attendance/excel/{date}/{enddate}/{employee_id}', [DocumentController::class, 'AttendenceExcelDocument']);
        Route::get('attendance/export-excel/{month}', [DocumentController::class, 'MonthlyAttendanceExcelDocument']);


        //_____ Leave Routes
        Route::get('/leave', [LeaveController::class, 'leave']);
        Route::get('/leave/add', [LeaveController::class, 'AddLeave']);
        Route::get('/leave/edit/{id}', [LeaveController::class, 'EditLeave']);
        Route::post('/leave/add', [LeaveController::class, 'SaveLeave'])->name('leave.save');
        Route::post('/leave/update/{id}', [LeaveController::class, 'UpdateLeave'])->name('leave.update');
        Route::delete('/leave_delete/{id}', [LeaveController::class, 'DeleteLeave']);
        Route::get('/leave/view/{id}', [LeaveController::class, 'LeaveView']);

        Route::get('leave_type', [LeaveController::class, 'LeaveType']);
        Route::post('leave_type', [LeaveController::class, 'LeaveTypeSave'])->name('leave.type');
        // Route::get('leave_type/delete/{id}', [LeaveController::class, 'LeaveTypeDelete']);
        Route::get('/leave/assign', [LeaveController::class, 'Assignleave']);
        Route::post('/leave/assign', [LeaveController::class, 'AssignleaveSave'])->name('leave.assign');
        Route::get('/leave/assign/history', [LeaveController::class, 'AssignleaveHistory']);
        Route::get('leave/record/{id}', [LeaveController::class, 'AssignleaveRecord']);
        Route::get('/leave/assign', [LeaveController::class, 'Assignleave']);




        Route::get('/humanResource', [HumanResourceController::class, 'HumanResource']);
        Route::get('/humanResource/add', [HumanResourceController::class, 'AddHumanResource']);
        Route::get('/humanResource/edit/{id}', [HumanResourceController::class, 'EditHumanResource']);
        Route::post('/humanResource/add', [HumanResourceController::class, 'SaveHumanResource'])->name('humanResource.save');
        Route::post('/humanResource/update/{id}', [HumanResourceController::class, 'UpdatehumanResource'])->name('humanResource.update');
        Route::delete('/humanResource_delete/{id}', [HumanResourceController::class, 'DeletehumanResource']);



        Route::get('/humanResource/candidate', [CandidateController::class, 'Candidate']);
        Route::get('/humanResource/candidate/add', [CandidateController::class, 'AddCandidate']);
        Route::get('/humanResource/candidate/edit/{id}', [CandidateController::class, 'EditCandidate']);
        Route::post('/humanResource/candidate/add', [CandidateController::class, 'SaveCandidate'])->name('candidate.save');
        Route::post('/humanResource/candidate/update/{id}', [CandidateController::class, 'UpdateCandidate'])->name('candidate.update');
        Route::delete('/candidate_delete/{id}', [CandidateController::class, 'DeleteCandidate']);
        Route::get('/humanResource/candidate/view-candidate/{id}', [CandidateController::class, 'viewcandidate'])->name('view-candidate');

        Route::get('/humanResource/interview', [InterviewController::class, 'Interview']);
        Route::get('/humanResource/interview/add', [InterviewController::class, 'AddInterview']);
        Route::get('/humanResource/interview/edit/{id}', [InterviewController::class, 'EditInterview']);
        Route::post('/humanResource/interview/add', [InterviewController::class, 'SaveInterview'])->name('interview.save');
        Route::post('/humanResource/interview/update/{id}', [InterviewController::class, 'UpdateInterview'])->name('interview.update');
        Route::delete('/interview_delete/{id}', [InterviewController::class, 'DeleteInterview']);
        Route::get('/humanResource/interview/view-interview/{id}', [InterviewController::class, 'viewInterview'])->name('view-interview');




        //_____ Setting Routes    
        Route::get('/setting', [SettingController::class, 'Setting']);
        Route::get('/setting/add', [SettingController::class, 'AddSetting']);
        Route::get('/setting/edit/{id}', [SettingController::class, 'EditSetting']);
        Route::post('/setting/add', [SettingController::class, 'SaveSetting'])->name('setting.save');
        Route::post('/setting/update/{id}', [SettingController::class, 'UpdateSetting'])->name('setting.update');

        Route::get('/setting/configuration', [SettingController::class, 'CacheConfiguration']);




        //_____ PageLength Routes
        Route::get('/setting/pagelength', [PageLengthController::class, 'PageLength']);
        Route::get('/setting/pagelength/add', [PageLengthController::class, 'AddPageLength']);
        Route::get('/setting/pagelength/edit/{id}', [PageLengthController::class, 'EditPageLength']);
        Route::post('/setting/pagelength/add', [PageLengthController::class, 'SavePageLength'])->name('pagelength.save');
        Route::post('/setting/pagelength/update/{id}', [PageLengthController::class, 'UpdatePageLength'])->name('pagelength.update');


        //_____ Support Routes
        Route::get('/support', [SupportController::class, 'Support']);
        Route::get('/support/add', [SupportController::class, 'AddSupport']);
        Route::get('/support/edit/{id}', [SupportController::class, 'EditSupport']);
        Route::post('/support/add', [SupportController::class, 'SaveSupport'])->name('support.save');
        Route::post('/support/update/{id}', [SupportController::class, 'UpdateSupport'])->name('support.update');
        Route::put('/support/change-status/{id}', [SupportController::class, 'changeStatus']);
        Route::delete('/support/delete/message/{id}', [SupportController::class, 'deleteMessage'])->name('support.delete.message.admin');
        // Route::get('/support/view', [SupportController::class, 'viewSupportMessage']);  

        // Business Routes 
        Route::get('business', [AdminBusinessController::class, 'Business']);
        Route::get('bids/view/{id}', [AdminBusinessController::class, 'BidsViews']);
        Route::get('leads/view/{id}', [AdminBusinessController::class, 'LeadsViews']);

        Route::get('bid-data-ajax', [AdminBusinessController::class, 'BidDataAjax'])->name('bid.data.ajax');

        Route::post('bidder/feedback', [AdminBusinessController::class, 'BidderFeedback']);

       

        // Notifcations
        Route::get('notifications', [NotificationController::class, 'Notification']);
        Route::post('send/notifications', [NotificationController::class, 'NotificationSend'])->name('send.notification');

        Route::get('mobile-app-notify', [NotificationController::class, 'MobileNotify']);
        Route::post('mobile-app-notification', [NotificationController::class, 'MobileNotificationSend'])->name('send.notification.mobile');

        
    });
});
Route::get('/get-interviewers', [InterviewController::class, 'getInterviewersByDepartment'])->name('getInterviewersByDepartment');

Route::get('/humanResource/job-view/{id}', [HumanResourceController::class, 'viewJob'])->name('job-view');
Route::group(['prefix' => 'employee', 'namespace' => 'employee'], function () {
    Route::get('/login', [AuthEmployeeController::class, 'getLogin'])->name('employeeLogin');
    Route::post('/login', [AuthEmployeeController::class, 'postLogin'])->name('employeeLoginPost');

    Route::group(['middleware' => 'employeeauth'], function () {
        Route::get('/', [EmployeeDashboardController::class, 'index'])->name('employeeDashboard');
        Route::get('/logout', [AuthEmployeeController::class, 'employeeLogout']);

        Route::get('/profile', [EmployeeDashboardController::class, 'EmployeeProfile']);
        Route::get('/sign-in', [EmployeeAttendanceController::class, 'SignIn']);
        Route::get('/sign-out', [EmployeeAttendanceController::class, 'SignOut']);
        Route::get('/attendence', [EmployeeAttendanceController::class, 'EmployeeAttendence']);
        Route::get('/attendence/calender', [EmployeeAttendanceController::class, 'AttendenceCalendar']);
        Route::get('/attendence/history', [EmployeeAttendanceController::class, 'EmployeeAttendenceHistory']);
        Route::get('/attendence/reocrds', [EmployeeAttendanceController::class, 'EmployeeAttendenceRecords'])->name('attendance.records');

        Route::get('/projects', [EmployeeProjectController::class, 'Project']);
        Route::get('/project/detail/{id}', [EmployeeProjectController::class, 'ProjectDetail']);
        Route::post('/project-report', [EmployeeProjectController::class, 'ProjectReport']);

        Route::get('/view/task/{id}', [EmployeeProjectController::class, 'TaskView']);
        Route::post('/submit/task', [EmployeeProjectController::class, 'SubmitTask'])->name('submit.report');

        // Task List
        Route::get('/projects/task_list', [EmployeeProjectController::class, 'TaskList']);


        //learning
        Route::get('/science', [EmployeeProjectController::class, 'ScienceNews']);
        Route::get('/science/blogs', [EmployeeProjectController::class, 'ScienceBlogs']);

        Route::get('/leave', [EmployeeLeaveController::class, 'Leave']);
        Route::get('/leave/apply', [EmployeeLeaveController::class, 'GetApplyLeave']);
        Route::post('/leave-apply', [EmployeeLeaveController::class, 'ApplyLeave']);
        Route::get('/leave-apply/{assign_id}', [EmployeeLeaveController::class, 'ApplyLeaveGet']);
        Route::get('/team/leave', [EmployeeLeaveController::class, 'TeamLeave']);
        Route::get('/team/view/{id}', [EmployeeLeaveController::class, 'TeamLeaveView']);
        Route::post('team-member-leave/{id}', [EmployeeLeaveController::class, 'TeamMemberAction']);

        Route::get('/interview', [EmployeeInterviewController::class, 'Interview']);
        Route::get('/interview/view/{id}', [EmployeeInterviewController::class, 'ViewCandidate']);
        Route::post('/candidate/feedback/{id}', [EmployeeInterviewController::class, 'CandidateFeedback'])->name('candidate.feedback');
        Route::get('/support', [EmployeeSupportController::class, 'Support']);
        Route::post('/support/add', [EmployeeSupportController::class, 'AddSupport'])->name('support.add');
        // Route::get('/support/edit/{id}', [EmployeeSupportController::class, 'EditSupport']);
        // Route::post('/support/add', [EmployeeSupportController::class, 'SaveSupport'])->name('support.save');
        Route::post('/support/update/{id}', [EmployeeSupportController::class, 'UpdateSupport']);
        Route::get('/support/message/{id}', [EmployeeSupportController::class, 'MessagesSupport']);
        Route::post('/support/add/message', [EmployeeSupportController::class, 'AddSupportMessage']);
        Route::delete('/support/delete/{id}', [EmployeeSupportController::class, 'delete'])->name('support.delete');
        // Route::get('/support/edit.message/{id}', [EmployeeSupportController::class, 'editMessage'])->name('support.edit.message');

        Route::delete('/support/delete/message/{id}', [EmployeeSupportController::class, 'deleteMessage'])->name('support.delete.message');







        Route::group(['middleware' => 'bidder'], function () {

            Route::get('/bidder', [BidderController::class, 'BidderIndex']);
            Route::get('/bids', [BidderController::class, 'MyBid']);
            Route::get('/bid/add', [BidderController::class, 'MyBidAdd']);
            Route::post('/bid/add', [BidderController::class, 'MyBidSave'])->name('bids.save');
            Route::get('ajax/upwork_id', [BidderController::class, 'Upwork']);
            Route::delete('bid/delete_bid/{id}', [BidderController::class, 'DeleteBid']);


            Route::get('/leads', [LeadController::class, 'Lead']);
            Route::get('/lead/add', [LeadController::class, 'MyLeadAdd']);
            Route::post('/lead/add', [LeadController::class, 'MyleadSave'])->name('leads.save');
            Route::delete('lead/delete_bid/{id}', [LeadController::class, 'Deletelead']);
            Route::get('lead/edit/{id}', [LeadController::class, 'LeadEdit']);
            Route::post('lead/edit/{id}', [LeadController::class, 'LeadUpdate'])->name('leads.update');

            Route::get('/contracts', [ContractController::class, 'Index']);
            Route::get('/contract/add', [ContractController::class, 'ContractAdd']);
            Route::post('/contract/add', [ContractController::class, 'ContractSave'])->name('contract.save');
            Route::get('contract/edit/{id}', [ContractController::class, 'ContractEdit']);
            Route::post('contract/edit/{id}', [ContractController::class, 'ContractUpdate'])->name('contract.update');
            Route::get('contract/tasks-view/{id}', [ContractController::class, 'ContractTasks']);
        });


        Route::group(['middleware' => 'hr'], function () {
            Route::get('/hr', [HRController::class, 'HRIndex']);
            Route::get('/hr/attendance', [HRController::class, 'HRAttendance']);
            Route::get('/hr/attendence/calender/{id}', [HRController::class, 'HRCalender']);
            Route::get('/hr/attendence/edit', [HRController::class, 'HRAttendanceEdit']);
            Route::get('/hr/attendence/records/{id}', [HRController::class, 'HRAttendanceRecords']);

            // HRAttandenceRecord Routes
            Route::get('hr/attendance/files', [HRAttandenceRecord::class, 'AttendanceFile']);
            Route::get('hr/attendance/file/records', [HRAttandenceRecord::class, 'AttendanceFileRecords']);
            Route::get('hr/ajax-attendance-records', [HRAttandenceRecord::class, 'AjaxAttendanceHR']);

            Route::get('hr/attendance/pdf/{date}/{enddate}/{employee_id}', [DocumentController::class, 'AttendencePDFDocument']);
            Route::get('hr/attendance/excel/{date}/{enddate}/{employee_id}', [DocumentController::class, 'AttendenceExcelDocument']);
            // 
            Route::get('/hr/job', [HRJobController::class, 'HRJob']);
            Route::get('hr/job/add', [HRJobController::class, 'HRAddJob']);
            Route::get('hr/humanResource/edit/{id}', [HRJobController::class, 'HREditJob']);
            Route::post('hr/humanResource/edit/{id}', [HRJobController::class, 'HrJobUpdate'])->name('hr.humanResource.update');
            Route::post('hr/job/add', [HRJobController::class, 'HRAddSave'])->name('hr.humanResource.save');
            Route::delete('hr/delete_job/{id}', [HRJobController::class, 'HRDeleteJob']);

            Route::get('hr/candidate', [HRCandidateController::class, 'HRCandidate']);
            Route::get('hr/candidate/add', [HRCandidateController::class, 'HRAddCandidate']);
            Route::post('hr/candidate/add', [HRCandidateController::class, 'HRStoreCandidate'])->name('hr.candidate.save');
            Route::get('hr/candidate/edit/{id}', [HRCandidateController::class, 'HREditCandidate']);
            Route::post('hr/candidate/edit/{id}', [HRCandidateController::class, 'HRUpdateCandidate'])->name('hr.candidate.update');
            Route::delete('hr/candidate_delete/{id}', [HRCandidateController::class, 'HRDeleteCandidate']);

            Route::get('hr/interview/', [HRInterviewController::class, 'HrInterview']);
            Route::get('hr/interview/add', [HRInterviewController::class, 'HrInterviewAdd']);
            Route::post('hr/interview/add', [HRInterviewController::class, 'HrInterviewStore'])->name('hr.interview.save');

            Route::get('hr/interview/edit/{id}', [HRInterviewController::class, 'HrInterviewEdit']);
            Route::post('hr/interview/edit/{id}', [HRInterviewController::class, 'HrInterviewUpdate'])->name('hr.interview.update');
            Route::delete('hr/interview_delete/{id}', [HRInterviewController::class, 'HRDeleteInterview']);
        });


        Route::group(['middleware' => 'team.leader'], function () {
            Route::get('tl', [TeamLeaderController::class, 'TeamIndex']);
            Route::post('tl/assign-task', [TeamLeaderController::class, 'TeamTask'])->name('task.assign.tl');
            Route::get('tl/project/task/{id}', [TeamLeaderController::class, 'TeamTaskList']);
            Route::get('tl/task/reports/{id}', [TeamLeaderController::class, 'TeamTaskReport']);
           
        });




    });
});

//Ajax Routes
Route::get('/getEmployees', [ProjectController::class, 'getEmployeesByDepartment'])->name('getEmployees');
Route::get('/fetch-upwork-options', [ProjectController::class, 'fetchUpworkOptions'])->name('fetch-upwork-options');
