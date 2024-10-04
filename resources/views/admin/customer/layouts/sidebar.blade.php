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

                            <span>Dashboard</span>

                        </a>

                    </li>



                    <li class="nav-item">

                        <a href="{{url('admin/customer')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-users4"></i>

                            <span>Customer</span>

                        </a>

                    </li>



                    <li class="nav-item">

                        <a href="{{url('admin/banner_list')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-newspaper"></i>

                            <span>Banner</span>

                        </a>

                    </li>

                    
                    <li class="nav-item">

                        <a href="{{url('admin/intro_sliders')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-color-sampler"></i>

                            <span>Intro Sliders</span>

                        </a>

                    </li>
                    

                    <li class="nav-item">

                        <a href="{{url('admin/slides_list')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-color-sampler"></i>

                            <span>Slides</span>

                        </a>

                    </li>



                    <!-- <li class="nav-item">

                        <a href="{{url('admin/slides_list')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-user-check"></i>

                            <span>Customer Order</span>

                        </a>

                    </li> -->



                    <!-- <li class="nav-item">

                        <a href="{{url('admin/slides_list')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-question4"></i>

                            <span>Customer Query</span>

                        </a>

                    </li>-->



                    <li class="nav-item">

                        <a href="{{url('admin/customer_query')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-bubbles3"></i>

                            <span>Customer Review</span>

                        </a>

                    </li> 


                    <li class="nav-item">

                        <a href="{{url('admin/app_link')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-question4"></i>

                            <span>App Link</span>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="{{url('admin/term_condition')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">

                            <i class="icon-question4"></i>

                            <span>Terms And Conditions</span>

                        </a>

                    </li>
                    <li class="nav-item">

                        <a href="{{url('admin/customer_policy')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">
                             <i class="icon-question4"></i>
                            <span>Privacy Policy</span>

                        </a>

                    </li>
                    
                    <!-- <li class="nav-item">

                        <a href="{{url('admin/about_us')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">
                             <i class="icon-question4"></i>
                            <span>About Us</span>

                        </a>

                    </li> -->

                    <!-- <li class="nav-item">

                        <a data-toggle="collapse" href="#dropdown-lvl3" class="nav-link" aria-expanded="true">

						<i class="icon-grid4" aria-hidden="true"></i> Category

						  <span class="caret"></span>

                            </a>

                            <div id="dropdown-lvl3" class="panel-collapse collapse show" style="">

							<div class="panel-body">

								<ul class="nav navbar-nav">

								    <li class="pane3	 panel-default" id="dropdown">

										<a class="dropdown-item" href="{{url('admin/slides_list')}}" class="nav-link {{Request::segment(1)=='home' ? 'active' : ''}}">Category</a>

							        	<a class="dropdown-item" href="#">Subcategory</a>

                                        <a class="dropdown-item" href="#">Inner Category</a>

									</li>

								</ul>

							</div>

						</div>

                    </li> -->



                   

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