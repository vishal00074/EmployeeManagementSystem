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

                        <i class="bi-border-all"></i>

                            <span>

                                Dashboard

                            </span>

                        </a>

                    </li>



                    <li class="nav-item">

                        <a href="{{url('admin/hompage')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                        <i class="bi-house"></i>

                            <span>

                                Home

                            </span>

                        </a>

                    </li>



                    <li class="nav-item">

                        <a href="{{url('admin/website_banners')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                        <i class="bi-image"></i>

                            <span>

                                Banner

                            </span>

                        </a>

                    </li>

                    <li class='sub-menu'>

                        <a href="{{url('admin/sponser')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-people"></i>

                            <span>

                              Soponser

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>



                    <li class='nav-item'>

                        <a href="{{url('admin/about')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <!--<span class="micon dw dw-user"></span>-->

                            <i class="bi-file-earmark-person"></i>

                            <span>

                                About

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>





                    <li class='nav-item'>

                        <a href="{{url('admin/howwamdeworks')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-bookmarks"></i>

                            <span>

                                How Waamde Works

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>





                    <li class='sub-menu'>

                        <a href="{{url('admin/contactus')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-person-lines-fill"></i>

                            <span>

                                Customer Reports

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>

                    <li class='sub-menu'>

                        <a href="{{url('admin/address')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-chat-square-text"></i>

                            <span>

                                Contact Us

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>





                    <li class='sub-menu'>

                        <a href="{{url('admin/faq')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-chat-square-text"></i>

                            <span>

                                FAQ

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>







                    <li class='sub-menu'>

                        <a href="{{url('admin/blog')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-bootstrap"></i>

                            <span>

                                Blogs

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>



                    

                    <li class='sub-menu'>

                        <a href="{{url('admin/seo')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-search"></i>

                            <span>

                                Seo Content

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>









                    <li class='sub-menu'>

                        <a href="{{url('admin/terms')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-list-task"></i>

                            <span>

                                Terms & Conditions

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>







                    <li class='sub-menu'>

                        <a href="{{url('admin/policy')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-list-check"></i>

                            <span>

                                Privacy Policy

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>



                    



                    <li class='sub-menu'>

                        <a href="{{url('admin/social')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <span class="micon dw dw-user"></span>

                            <i class="bi-link"></i>

                            <span>

                               Social Link

                            </span>

                        </a>

                        <ul>

                        </ul>

                    </li>















                    <!--<li class="sub-menu">-->

                    <!--    <a href="javascript:;" class=" dropdown-toggle nav-link {{Request::segment(1)=='franchise-inquiries' ? 'active' : ''}}">-->

                    <!--    <span class="micon dw dw-user"></span>-->

                    <!--        <i class="icon-cart"></i>-->

                    <!--        <span>-->

                    <!--            Vendor General-->

                    <!--        </span>-->

                    <!--    </a>-->



                    <!--    <ul >-->

                    <!--      <li><a href="{{url('/admin/vendor')}}" class="text-white">Vendor</a></li>-->

                    <!--      <li><a href="{{url('/admin/vendor_queries')}}" class="text-white">Vendor Quries</a></li>-->

                    <!--      <li><a href="{{url('/admin/membership_list')}}" class="text-white">Membership Details</a></li>-->

                    <!--    </ul>-->

                    <!--</li>-->



                    <!--<li class="nav-item">-->

                    <!--    <a href="{{ url('/notification_list') }}" class="nav-link ">-->

                    <!--        <i class="icon-cart"></i>-->

                    <!--        <span>-->

                    <!--            Send Notification-->

                    <!--        </span>-->

                    <!--    </a>-->

                    <!--</li>-->

                </ul>

            </div>

            <!-- /main navigation -->



        </div>

        <!-- /sidebar content -->



    </div>

    <!-- /main sidebar -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script>

        $('.sub-menu ul').hide();

        $(".sub-menu a").click(function() {

            $(this).parent(".sub-menu").children("ul").slideToggle("100");

            $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");

        });

    </script>