<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('admin.layouts.head')
@yield('css')
</head>
<body>
<div class="loading hide"><img src="{{asset('public/assets/admin/img/loader.gif')}}"></div>
@if(Auth::guard('admin'))
    @include('admin.layouts.header')
    <!-- Page content -->
    <div class="page-content">
        @include('admin.customer.extra.sidebar')
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
                            <h5 class="mt-2">ADMIN - Homepage</h5>
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