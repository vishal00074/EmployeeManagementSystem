@extends('admin.attendence.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Generate PDF</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/attendence') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <!--<h4><b>Add Details</b></h4>-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="enddate" id="enddate">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Employee</label>
                                <select class="form-control" name="employee_id" id="employee_id">
                                    <option value="">Select</option>
                                    <option value="0">All Employees</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submit_form">Generate<i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="row s-filter">
            <div class="col-md-3">
                <h5 class="ml-2 mb-0" id="links">
                    <!-- <a href="{{ url('admin/department/add') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> PDF</button></a> -->
                </h5>
            </div>
            <div class="col-md-7" align="right">
            </div>
        </div>

        <table class="table get_Customer_details table-bordered">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time out</th>
                    <th>Total Hours</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="attendance-data">

            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#submit_form').on('click', function() {

            var date = $('#date').val();
            var enddate = $('#enddate').val();

            var employee_id = $('#employee_id').val();
            var links = $('#links');
            var attendancedata = $('#attendance-data');
            var btn = document.getElementById('submit_form');
            btn.disabled = true;
            btn.innerText = 'generating...'

            $.ajax({
                url: "{{ url('admin/ajax-attendance-records') }}",
                type: "GET",
                data: {
                    date: date,
                    employee_id: employee_id,
                    enddate: enddate
                },
                datatype: 'json',
                success: function(response) {
                    var is_link =response.pdflink;

                    attendancedata.empty();
                    links.empty();
                    var linkvalue = `<a href="{{ url('`+  response.pdflink +`') }}"><button type="button" class="btn btn-danger btn-sm" ><i class="icon-plus-circle2 mr-2"></i> PDF</button></a>`;
                        linkvalue +=`  <a href="{{ url('`+  response.excellink +`') }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Excel</button></a>`;

                        if(is_link){
                            links.append(linkvalue); 
                        }
                        

                        if (response.status == true) {
                        var successdata = response.data;

                        var successattendance = ''; 
                        for (var i = 0; i < successdata.length; i++) {
                            successattendance += '<tr>'; 

                            // Append data for each column
                            successattendance += '<td>' + successdata[i].employeeName + '</td>';
                            successattendance += '<td>' + successdata[i].date + '</td>';
                            successattendance += '<td>' + successdata[i].time_in + '</td>';
                            successattendance += '<td>' + successdata[i].time_out + '</td>';
                            successattendance += '<td>' + successdata[i].total_hours + '</td>';
                            successattendance += '<td>' + successdata[i].status + '</td>';

                            successattendance += '</tr>'; // Close the row
                        }

                        attendancedata.append(successattendance)


                        notify('success', "success")
                        btn.disabled = false;
                        btn.innerText = 'Generate'
                    } else {
                        notify('error', 'Failed');
                        btn.disabled = false;
                        btn.innerText = 'Generate'
                    }

                },
                error: function(response) {
                    notify('error', 'Opps! something went wrong');
                    btn.disabled = false;
                    btn.innerText = 'Generate'
                },



            });
            var swalInit = swal.mixin({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-light'

            });
        });

    });
</script>
@endsection