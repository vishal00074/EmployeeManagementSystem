@extends('admin.setting.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Application Configuration and Cache</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/setting') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cache Config</label>
                                <button class="btn btn-danger" id="config">Config</button>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>View Clear</label>
                                <button class="btn btn-warning" id="view">View</button>

                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Route Clear</label>
                                <button class="btn btn-danger"  id="route">Clear</button>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cache Clear</label>
                                <button class="btn btn-success" id="clear">Clear</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        /*------------------------------------------
        --------------------------------------------
        When click user on Show Button
        --------------------------------------------
        --------------------------------------------*/
        $('#config').on('click', function() {



            $.ajax({
                url: "{{ url('admin/config-cache') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    notify('success', 'Cache Configured')
                }
            });

        });

        $('#view').on('click', function() {
            $.ajax({
                url: "{{ url('admin/view-clear') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    notify('success', 'View Cleared')
                }
            });

        });



        $('#route').on('click', function() {
            $.ajax({
                url: "{{ url('admin/route-cache') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    notify('success', 'Route Cleared')
                }
            });

        });


        $('#clear').on('click', function() {
            $.ajax({
                url: "{{ url('admin/clear-cache') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    notify('success', 'Cache Cleared')
                }
            });

        });

    });
</script>
@endsection