@extends('admin.attendence.app')

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
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-3">
                <h5 class="ml-2 mb-0">

                    <b>Employee Attendance Calender</b>
                </h5>
            </div>
            <div class="col-md-7" align="right">

                <a href="{{ url('admin/attendence/') }}"><button type="button" class="btn btn-primary btn-sm">Back</button></a>

            </div>
        </div>
        <!--  -->
        <div id='calendar'></div>


        <!--  -->


    </div>
    <!-- /page length options -->
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
                        url: "{{ url('/admin/attendence/edit') }}",
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

<!-- <script>
    $(document).ready(function() {
        $(".fc-past").hover(function() {
           
            var employeeId = <?php echo $id; ?>;
            var date = $(this).data('date');
            var $element = $(this); 

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.attendance.records') }}",
                data: {
                    date: date,
                    employee_id: employeeId
                },
                success: function(data) {
                    var emptypopup=  $('.popup');
                   
                    emptypopup.empty();
                  
                    var popup = $('<div class="popup"><p>Attendance Records for the ' + date +'</p><ul></ul></div>');
                   

                    for (var i = 0; i < data.Data.length; i++) {
                        popup.find('ul').append('<li>Time in: ' + data.Data[i].time_in + ', Time out: ' + data.Data[i].time_out + '</li>');
                    }

                    popup.css({
                        'background-color': 'rgba(56 56 56)',
                        'color': 'white',
                        'position': 'absolute',
                        'top': '20px',
                        'left': '20px',
                        'padding': '10px',
                        'border-radius': '5px',
                    });

                   
                    $element.append(popup); 
                }
            });
        }, function() {
            $(this).find('.popup').remove();
        });
    });
</script> -->
@endsection