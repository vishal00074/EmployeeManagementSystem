<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('admin.layouts.head')
@yield('css')
</head>
<body>
<div class="loading hide"><img src="{{asset('assets/admin/img/loader.gif')}}"></div>
@if(Auth::guard('admin'))
    @include('admin.layouts.header')
    <!-- Page content -->
    <div class="page-content">
        @include('admin.attendence.layouts.sidebar')
@endif
        <!-- Main content -->
		<div class="content-wrapper">
            <div class="content-inner">
            @if(Auth::guard('admin'))
                @php $bread2=''; @endphp
                <!-- Page header -->
                <div class="page-header page-header-light">
                    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                        <div class="d-flex">
                            <h5 class="mt-2">Attendance</h5>
                            <!--<div class="breadcrumb">-->
                            <!--    <a href="{{url('admin/dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>-->
                                <!-- <a href="{{strtolower($bread2)}}" class="breadcrumb-item">{{$bread2}}</a> -->
                            <!--    @if(!empty(Request::segment(3))) -->
                            <!--    <span class="breadcrumb-item active">{{ ucwords(str_replace('_',' ',Request::segment(3))) }}</span>-->
                            <!--    @endif-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
                <!-- /page header -->
            @endif

            @yield('content')
            
            @if(Auth::guard('admin'))
                @include('admin.layouts.footer')
            @endif
            </div>
        </div>
        
        <script>
            var base_url = `<?php echo URL::to('/');?>`;
            var asset_url = `<?php echo URL::to('/');?>`;
            $(document).ready(function(){
                var success = `<?php echo Session::get('success'); ?>`;
              
                if(success){
                    notify('success',success)
                }
                var error = `<?php echo Session::get('error'); ?>`;
            
                if(error){
                  
                    notify('error',error)
                }
            });
            var swalInit = swal.mixin({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-light'
            });
          

        </script>
        @yield('script')
    </div>

</body>
</html>