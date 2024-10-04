    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Main navigation -->
            <div class="card card-sidebar-mobile" id="sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item">
                        <a href="{{url('admin/dashboard')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">
                            <i class="icon-home4"></i>
                            <span>
                                Dashboard
                            </span>
                        </a>
                    </li>

                    <li class='sub-menu'>
                         <a href='javascript:;' class=" dropdown-toggle nav-link {{Request::segment(1)=='franchise-inquiries' ? 'active' : ''}}" >
                         <span class="micon dw dw-user"></span>
                             <i class="icon-cart"></i>
                             <span>
                                 General
                            </span>
                            </a>
                       <ul >
                          <li><a href="{{url('admin/customer')}}" class="text-white">Customer</a></li>
                          <li><a href="{{url('admin/order_list')}}" class="text-white">Order List</a></li>
                          <li><a href="{{url('admin/banner_list')}}" class="text-white">Banner</a></li>
                          <li><a href="{{url('admin/slides_list')}}" class="text-white">Add Slides</a></li>
                          <li><a href="{{url('admin/terms_&_conditions')}}" class="text-white">Terms & Conditions</a></li>
                          <li><a href="{{url('admin/view_privacy')}}" class="text-white">Privacy Policy</a></li>
                          <li><a href="{{url('admin/contact_us')}}" class="text-white">Contact Us</a></li>
                          <li><a href="{{url('admin/about_us')}}" class="text-white">About Us</a></li>
                       </ul>
                    </li>                    
                 
                    <li class="sub-menu">
                        <a href="javascript:;" class=" dropdown-toggle nav-link {{Request::segment(1)=='franchise-inquiries' ? 'active' : ''}}">
                        <span class="micon dw dw-user"></span>
                            <i class="icon-cart"></i>
                            <span>
                                Vendor General
                            </span>
                        </a>

                        <ul >
                          <li><a href="{{url('/admin/vendor')}}" class="text-white">Vendor</a></li>
                          <li><a href="{{url('/admin/vendor_queries')}}" class="text-white">Vendor Quries</a></li>
                          <li><a href="{{url('/admin/membership_list')}}" class="text-white">Membership Details</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/admin/notification_list') }}" class="nav-link ">
                            <i class="icon-cart"></i>
                            <span>
                                Send Notification
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->
    <script>
        $('.sub-menu ul').hide();
$(".sub-menu a").click(function () {
  $(this).parent(".sub-menu").children("ul").slideToggle("100");
  $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
});
    </script>