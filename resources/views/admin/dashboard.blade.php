<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/xpertidea_logo.png') }}">
  
    @include('admin.layouts.head')
    @yield('css')
</head>

<body>
    <div class="loading hide"><img src="{{asset('assets/admin/img/loader.gif')}}"></div>
    @include('admin.layouts.header')
    <!-- Page content -->
    <div class="page-content">
        <!-- Content area -->
        <div class="content-wrapper">
            <div class="content-inner">
                @if(Auth::guard('admin'))
                @php $bread2=''; @endphp
                <!-- Page header -->
                <div class="page-header page-header-light">
                    <!--<div class="page-header-content header-elements-md-inline">-->
                    <!--    <div class="page-title d-flex">-->
                    <!--        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{ ucfirst(Request::segment(1)) }}</span>  @if(!empty(Request::segment(2))) {{'-'}} @endif {{ $bread2=ucwords(str_replace('_',' ',Request::segment(2))) }}</h4>-->
                    <!--        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                        <div class="d-flex">
                            <div class="breadcrumb">
                                <div class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Dashboard</div>
                                <a href="{{url('admin/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Home</a>
                                <a href="{{url('admin/graph')}}" class="breadcrumb-item"><i class="icon-graph mr-2"></i>Graphs</a>
                                <a href="{{strtolower($bread2)}}" class="breadcrumb-item">{{$bread2}}</a>
                                @if(!empty(Request::segment(3)))
                                <span class="breadcrumb-item active">{{ ucwords(str_replace('_',' ',Request::segment(3))) }}</span>
                                @endif
                            </div>
                            <!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
                        </div>
                    </div>
                </div>

                <!-- /page header -->
                @endif
                <div class="content">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Quick stats boxes -->
                            <div class="row dashboard ml-5 mr-5 mt-4">
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/employee/reports')  }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/41.jpg')}}">
                                                    <span>Employee Report</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/department')  }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/analytics.jpg')}}">
                                                    <span>Department</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/designation') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/advantage.png')}}">
                                                    <span>Designation</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/employee') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/coordination.png')}}">
                                                    <span>Employee</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/upwork')  }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/upwork.png')}}" width="100px">
                                                    <span>Upwork</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-3 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{url('admin/agency')}}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/agency.png')}}" width="100px">
                                                    <span>Agency</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/shift') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/new_shift.png')}}" height="80px" width="100px">
                                                    <span>Shift</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/project') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/coordination.png')}}">
                                                    <span>Project</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/attendence') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/book.png')}}">
                                                    <span>Attendence</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/leave') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/scroll-icon-29281.png')}}">
                                                    <span>Leave</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/humanResource') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/analytics.jpg')}}">
                                                    <span>Hr Job Portal</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/rule') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/role.png')}}">
                                                    <span>Assign Role</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/business') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/business-management.png')}}">
                                                    <span>Business Management</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/notifications') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/notification.png')}}">
                                                    <span>Send Notifications</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/setting') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/setting-icon-vector-24647299.jpg')}}">
                                                    <span>Setting</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="serv-box text-center">
                                                <a href="{{ url('admin/support') }}" class="text-dark">
                                                    <img src="{{asset('assets/admin/img/Support-PNG-Transparent-Picture.png')}}">
                                                    <span>Support</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /quick stats boxes -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var base_url = `https://xpertideaitsolutions.com/`;
        var asset_url = `https://xpertideaitsolutions.com/`;
        $(document).ready(function() {
            var success = ``;
            if (success) {
                notify('success', success)
            }
            var error = ``;
            if (error) {
                notify('error', error)
            }
        });
        var swalInit = swal.mixin({
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-light'

        });
    </script>

</body>

</html>