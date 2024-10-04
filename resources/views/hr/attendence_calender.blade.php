@extends('employee.layouts.app')



@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<style>
        * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {}



    #calendar {
        width: 90%;
        margin: 40px auto;
    }
</style>

@endsection
@section('content')
<!-- Content area -->
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4 class="mb-4 student"><b>Attendance Calender</b></h4>
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
                            <a href="{{ url('employee') }}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                        </button>
                    </div>
                </div>
              

                <div id='calendar'></div>


            </div>
        </div>
    </div>
</div>


@endsection

@section('script')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events: [
                @foreach($combined_array as $key => $task) {
                    title: "{{ $task['attendence'] }}",
                    start: "{{ $task['date'] }}",
                    url: ''
                },
                @endforeach
            ],


        })



        $('body').on('click', '.fc-past', function() {
            var employeeId = <?php echo $id; ?>;
            var dateValue = $(this).data("date");

            swalInit.fire({
                title: 'Edit Time In/Out',
                html: `
            <input id="timeIn" type="time" placeholder="Time In">
            <input id="timeOut" type="time" placeholder="Time Out">
            <input id="remark" type="text" placeholder="Remark">
        `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            }).then(function(result) {
                if (result.value) {
                    var timeIn = $('#timeIn').val();
                    var timeOut = $('#timeOut').val();
                    var remark = $('#remark').val();

                    $.ajax({
                        type: 'GET', // Change request type to GET
                        url: "{{ url('employee/hr/attendence/edit') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            employee_id: employeeId,
                            dateValue: dateValue,
                            time_in: timeIn,
                            time_out: timeOut,
                            remark: remark
                        },
                        success: function(response) {

                            if (response.status == true) {
                                swalInit.fire({
                                    title: 'Submitted!',
                                    text: 'Time In/Out has been updated.',
                                    type: 'success'
                                }).then((willDelete) => {
                                    location.reload();
                                });
                            } else {
                                swalInit.fire({
                                    title: 'Error updating Time In/Out!',
                                    text: 'Please try again!',
                                    type: 'error'
                                }).then((willDelete) => {
                                    location.reload();
                                });
                            }

                        },
                        error: function(response) {
                            swalInit.fire({
                                title: 'Error updating Time In/Out!',
                                text: 'Please try again!',
                                type: 'error'
                            }).then((willDelete) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

    });
</script>



@endsection