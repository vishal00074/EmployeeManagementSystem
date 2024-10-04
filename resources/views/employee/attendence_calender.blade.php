@extends('employee.layouts.app')
@section('css')
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
<script>
    $(document).ready(function() {
        $(".fc-past").hover(function() {
            var date = $(this).data('date');
            var $element = $(this); 

            $.ajax({
                type: 'GET',
                url: "{{ route('attendance.records') }}",
                data: {
                    date: date
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
</script>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
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
            ]
        })
    });
</script>
@endsection