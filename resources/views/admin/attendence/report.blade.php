@extends('admin.attendence.app')

@section('css')
<style>
    .get_month_dates {
        width: 100%;
        border-collapse: collapse;
        /* Ensures the table doesn't add extra space between cells */
    }

    .get_month_dates th,
    .get_month_dates td {
        padding: 8px;
        /* Padding for cell content */
        text-align: center;
    }

    .get_month_dates th:not(:last-child),
    .get_month_dates td:not(:last-child) {
        border-right: 1px solid #000;
        /* Add a border to all cells except the last one */
    }

    .get_month_dates tr {
        border-bottom: 1px solid #000;
        /* Optional: horizontal lines between rows */
    }


    @media (max-width: 768px) {
        .get_month_dates {
            font-size: 12px;
            /* Reduce font size on smaller screens */
        }
    }
</style>
@endsection

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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select</label>
                                <input type="month" name="month" class="form-control" id="month">
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
                    <a href="{{ url('admin/attendance/export-excel') }}/{{ $monthNumber }}"><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Export Excel</button></a>
                </h5>
            </div>
            <div class="col-md-7" align="right">

            </div>
        </div>

        <div class="table-responsive" id="monthly_attendance">
            <table class="table get_month_dates">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Employee Name</th>
                        @foreach($dates as $date)
                        <th style="min-width: 105px;">{{ $date }}</th>
                        @endforeach
                        <th style="min-width: 105px;">Total Present</th>
                        <th style="min-width: 105px;">Total leave</th>
                        <th style="min-width: 105px;">Paid leave</th>
                        <th style="min-width: 105px;">Unpaid leave</th>

                    </tr>
                </thead>
                <tbody id="attendance-data">
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        @foreach($employee->attendance_status as $status)
                        <td>{{ $status }}</td>

                        @endforeach
                        <td>{{ $employee->total_present }}</td>
                        <td>{{ $employee->totalLeave }}</td>
                        <td>{{ $employee->paidLeave }}</td>
                        <td>{{ $employee->unpaidLeave }}</td>
                        
                    </tr>
                    @endforeach



                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#submit_form').on('click', function() {

            var month = $('#month').val();
            var links = $('#links');
            
            var btn = document.getElementById('submit_form');
            btn.disabled = true;
            btn.innerText = 'generating...'
            var monthly_attendance = $('#monthly_attendance');


            $.ajax({
                url: "{{ route('monthly.attendance') }}",
                type: "GET",
                data: {
                    month: month,

                },
                datatype: 'json',
                success: function(response) {

                    


                    if (response.status == true) {
                        // attendance Code
                        monthly_attendance.empty();
                        links.empty();
                        var responsedata =response.data;
                        var responseLink = response.link;
                        

                        monthly_attendance.append(responsedata);
                        links.append(responseLink);

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