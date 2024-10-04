@extends('admin.customer.extra.app')





@section('content')

@php

   $left_image= DB::table('web_front_banners')->where('type', '1')->orderby('created_at', 'desc')->first();

   $right_image= DB::table('web_front_banners')->where('type', '2')->orderby('created_at', 'desc')->first();

@endphp

<!-- Content area  -->
<div class="content">
  <!-- Page length options  -->
  <div class="card">
    <div class="card-header header-elements-inline">
      <div class="col-sm-6 mb-1" align="left">
        <h6 class="card-title"><b>Header</b></h6>
      </div>
    </div>



    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <form class="CustomerDetails" action="{{ url('/admin/web_banner_first/')}}" method="POST">
            @csrf
            <h4><b>Left Image Data</b></h4>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" name="title" value="{{ $left_image->title }}" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>French Title</label>
                  <input type="text" class="form-control" name="fr_title" value="{{ $left_image->fr_title }}" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" name="description" value="{{ $left_image->description }}" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>French Description</label>
                  <input type="text" class="form-control" name="fr_description" value="{{ $left_image->fr_description }}" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Link</label>
                  <input type="text" class="form-control" name="link" value="{{ $left_image->link }}">

                </div>

              </div>

            </div>

            <div class="row">

              <div class="col-md-12">

                <div class="text-center">

                  <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>

                </div>

              </div>

            </div>

          </form>

        </div>

        <div class="col-md-6">

          <form class="VendorDetails" action="{{ url('/admin/web_banner_second')}}" method="POST">

            @csrf

            <h4><b>Right Image Data</b></h4>

            <div class="row">

              <input type="hidden" name="vendor_data" value="">

              <div class="col-md-12">

                <div class="form-group">

                  <label>Title</label>

                  <input type="text" class="form-control" name="title" value="{{ $right_image->title }}">

                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label>French Title</label>

                  <input type="text" class="form-control" name="fr_title" value="{{ $right_image->fr_title }}" required>

                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label>Description</label>

                  <input type="text" class="form-control" name="description" value="{{ $right_image->description }}">

                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label>French Description</label>

                  <input type="text" class="form-control" name="fr_description" value="{{ $right_image->fr_description }}" required>

                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label>Link</label>

                  <input type="text" class="form-control" name="link" value="{{ $right_image->link }}">

                </div>

              </div>

            </div>

            <div class="row">

              <div class="col-md-12">

                <div class="text-center">

                  <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>



                </div>

              </div>

            </div>



          </form>

        </div>



      </div>

    </div>

  </div>

</div>





<div class="content">

  <!-- Page length options  -->

  <div class="card">

    <div class="card-header header-elements-inline">

      <div class="col-sm-6 mb-1" align="left">

        <h6 class="card-title"><b>Services</b></h6>

      </div>

    </div>



    <section id="services" class="services">

      <div class="container" data-aos="fade-up">



        <form action="" method="POST" enctype="multipart/form-data">

          @csrf

          <div class="section-title text-center">

            <h4>{{$individual->Title}}</h4>

          </div>

          <div class="row">



            <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">

              <div class="">



                <div class="icon"><img src="{{('/public/users/'.$individual->image)}}" alt="img" /></div>

                <h4 class="title"><a href="" data-toggle="modal" data-target="#myModal">{{$individual->service_title}}</a></h4>

                <p class="description">{{$individual->servicedescription}}</p>

              </div>

            </div>

            <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">

              <div class="">

                <div class="icon"><img src="{{('/public/users/'.$business->image)}}" alt="img" /></div>

                <h4 class="title"><a href="" data-toggle="modal" data-target="#mytilte">{{$business->service_title}}</a></h4>

                <p class="description">{{$business->servicedescription}}</p>

              </div>

            </div>

            <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">

              <div class="">

                <div class="icon"><img src="{{('/public/users/'.$partnersdeveloper->image)}}" alt="img" /></div>

                <h4 class="title"><a href="" data-toggle="modal" data-target="#mypartnerdevelopmentModal">{{$partnersdeveloper->service_title}}</a></h4>

                <p class="description">{{$partnersdeveloper->servicedescription}}</p>

              </div>

            </div>

          </div>

        </form>

      </div>

    </section>



    <!-- Modal -->

    <div class="modal fade" id="myModal" role="dialog" align="center">

      <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>



          <h3>Individuals</h3>

          <div class="modal-body">

            <form action="{{ url('/admin/services',$individual->id)}}" method="POST" enctype="multipart/form-data" align="left">

              @csrf

              <input type="hidden" name="individual_data" value="{{$individual->id}}">

              <!-- <label>Title</label>

                <input type ="text" name="title" class="form-control" value="{{$individual->Title}}"> -->

              <label>Service Title</label>

              <input type="text" name="service_title" class="form-control" value="{{$individual->service_title}}">



              <label>Service Title French</label>

              <input type="text" name="fr_service_title" class="form-control" value="{{$individual->fr_service_title}}">



              <label>Service Description</label>

              <input type="text" name="servicedescription" class="form-control" value="{{$individual->servicedescription}}">



              <label>Service Description French</label>

              <input type="text" name="fr_servicedescription" class="form-control" value="{{$individual->fr_servicedescription}}">



              <label>Image</label>

              <input type="file" name="image" id="image" class="form-control"><img src="{{('/public/users/'.$individual->image)}}" alt="">





              <div class="modal-footer">

                <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

              </div>



            </form>

          </div>

        </div>



      </div>

    </div>



    <div class="modal fade" id="mytilte" role="dialog" align="center">

      <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>



          <h3>Business</h3>

          <div class="modal-body">

            <form action="{{ url('/admin/services',$business->id)}}" method="POST" enctype="multipart/form-data" align="left">

              @csrf

              <input type="hidden" name="business_data" value="{{$business->id}}">



              <label>Service Title</label>

              <input type="text" name="service_title" class="form-control" value="{{$business->service_title}}">



              <label>Service Title French</label>

              <input type="text" name="fr_service_title" class="form-control" value="{{$business->fr_service_title}}">



              <label>Service Description</label>

              <input type="text" name="servicedescription" class="form-control" value="{{$business->servicedescription}}">



              <label>Service Description French</label>

              <input type="text" name="fr_servicedescription" class="form-control" value="{{$business->fr_servicedescription}}">



              <label>Image</label>

              <input type="file" name="image" id="image" class="form-control"><img src="{{('/public/users/'.$business->image)}}" alt="">



              <div class="modal-footer">

                <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

              </div>



            </form>

          </div>

        </div>



      </div>

    </div>

  </div>

</div>



<div class="content">

  <!-- Page length options  -->

  <div class="card">

    <div class="card-body">

      <div class="row">

        <div class="col-md-12">

          <form action="{{ url('/app_link')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <h1><b>App Details</b></h1>

            <div class="row">

              <input type="hidden" name="app_data" value="{{$app->id ?? '' }}">

              <div class="col-md-6">

                <div class="form-group">

                  <label>Title</label>

                  <input type="text" class="form-control" name="title" value="{{$app->title ?? '' }}">

                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">

                  <label>French Title</label>

                  <input type="text" class="form-control" name="fr_title" value="{{$app->fr_title ?? '' }}">

                </div>

              </div>



              <div class="col-md-6">

                <div class="form-group">

                  <label>Description</label>

                  <input type="text" class="form-control" name="description" value="{{$app->description ?? '' }}">

                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">

                  <label>French Description</label>

                  <input type="text" class="form-control" name="fr_description" value="{{$app->fr_description ?? '' }}">

                </div>

              </div>





              <div class="col-md-6">

                <div class="form-group">

                  <label>Android Link</label>

                  <input type="text" class="form-control" name="App_Link" value="{{$app->App_Link ?? ''}}">

                </div>

              </div>







              <div class="col-md-6">

                <div class="form-group">

                  <label>Ios Link</label>

                  <input type="text" class="form-control" name="Ios_link" value="{{$app->Ios_link ?? '' }}">

                </div>

              </div>



            </div>

            <div class="row">

              <div class="col-md-12">

                <div class="text-center">

                  <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>

                  <br><br>

                </div>

              </div>

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>

</div>





<div class="content">

  <!-- Page length options  -->

  <div class="card">

    <div class="card-header header-elements-inline">

      <div class="col-sm-6 mb-1" align="left">

        <h6 class="card-title"><b>Services</b></h6>

      </div>

    </div>



    <section class="join">

      <h1 class="text-center mb-5">{{$category1->categorytitle ?? '' }}</h1>

      <div class="container">

        <div class="row">



          <div class="col-sm-3">

            <div class="inside">

              <h4 class="title"><a href="" data-toggle="modal" data-target="#mycategory">{{$category1->title ?? '' }}</a></h4>

              <p>{{$category1->description ?? '' }}

              </p>

            </div>

          </div>

          <div class="col-sm-3">

            <div class="inside">

              <h4 class="title"><a href="" data-toggle="modal" data-target="#categoryservice">{{$category2->title ?? '' }}</a></h4>

              <p>{{$category2->description ?? ''  }}

              </p>

            </div>

          </div>

          <div class="col-sm-3">

            <div class="inside">

              <h4 class="title"><a href="" data-toggle="modal" data-target="#myservice">{{$category3->title ?? ''}}</a></h4>

              <p>{{$category3->description ?? '' }}

              </p>

            </div>

          </div>

          <div class="col-sm-3">

            <div class="inside">

              <h4 class="title"><a href="" data-toggle="modal" data-target="#mytitle">{{$category4->title ?? '' }}</a></h4>

              <p>{{$category4->description ?? '' }}

              </p>

            </div>

          </div>

        </div>

      </div>

    </section>

  </div>





  <div class="content">

    <!-- Page length options  -->

    <div class="card">

      <div class="card-header header-elements-inline">

        <div class="col-sm-6 mb-1" align="left">

          <h6 class="card-title"><b>Footer</b></h6>

        </div>

      </div>



      <div class="card-body">

        <div class="row">

          <div class="col-md-6">

            <form action="{{ url('/admin/footer_data')}}" method="POST" enctype="multipart/form-data">

              @csrf

              <!--<h4><b>Footer Details</b></h4>-->

              <div class="row">

                <input type="hidden" name="footer_data" value="{{$footer->id ??'' }}">

                <div class="col-md-12">

                  <div class="form-group">

                    <label>Address</label>

                    <input type="text" class="form-control" name="address" value="{{$footer->address ??'' }}">

                  </div>

                </div>

                <div class="col-md-12">

                  <div class="form-group">

                    <label>Email</label>

                    <input type="text" class="form-control" name="email" value="{{$footer->email ??'' }}">

                  </div>

                </div>



                <div class="col-md-12">

                  <div class="form-group">

                    <label>Phone</label>

                    <input type="text" class="form-control" name="phone" value="{{$footer->phone ??'' }}">

                  </div>

                </div>





              </div>

              <div class="row">

                <div class="col-md-12">

                  <div class="text-center">

                    <button type="submit" class="btn btn-primary" id="submit_form">Submit form <i class="icon-paperplane ml-2"></i></button>

                  </div>

                </div>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>





  <div class="modal fade" id="mypartnerdevelopmentModal" role="dialog" align="center">

    <div class="modal-dialog">



      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <h3>Partners And Developers</h3>

        <div class="modal-body">

          <form action="{{ url('/admin/services')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <input type="hidden" name="partnersdeveloper_data" value="{{$partnersdeveloper->id ?? '' }}">



            <label>Service Title</label>

            <input type="text" name="service_title" class="form-control" value="{{$partnersdeveloper->service_title ?? '' }}">



            <label>Service Title</label>

            <input type="text" name="fr_service_title" class="form-control" value="{{$partnersdeveloper->fr_service_title ?? '' }}">



            <label>Service Description</label>

            <input type="text" name="servicedescription" class="form-control" value="{{$partnersdeveloper->servicedescription ?? '' }}">



            <label>Service Description</label>

            <input type="text" name="fr_servicedescription" class="form-control" value="{{$partnersdeveloper->fr_servicedescription ?? '' }}">



            <label>Image</label>

            <input type="file" name="image"><img src="{{('/public/users/'.$partnersdeveloper->image  ?? '' )}}" alt="">





            <div class="modal-footer">

              <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

            </div>

          </form>

        </div>

      </div>



    </div>

  </div>







  <!--//category data -->



  <div class="modal fade" id="mycategory" role="dialog" align="center">

    <div class="modal-dialog">

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <h3>{{ $category1->title ?? '' }}</h3>

        <div class="modal-body">

          <form action="{{ url('/admin/category_web')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <input type="hidden" name="category_data" value="{{$category1->id ?? '' }}">



            <!-- <label>CategoryTitle</label>

            <input type="text" name="categorytitle" class="form-control" value="{{$category1->categorytitle ?? ''}}"> -->



            <label>Title</label>

            <input type="text" name="title" class="form-control" value="{{$category1->title ?? '' }}">



            <label>Title French</label>

            <input type="text" name="fr_title" class="form-control" value="{{$category1->fr_title ?? '' }}">



            <label>Description</label>

            <input type="text" name="description" class="form-control" value="{{$category1->description ?? '' }}">



            <label>Description French</label>

            <input type="text" name="fr_description" class="form-control" value="{{$category1->fr_description ?? '' }}">





            <div class="modal-footer">

              <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

            </div>

          </form>

        </div>

      </div>



    </div>

  </div>



  <div class="modal fade" id="categoryservice" role="dialog" align="center">

    <div class="modal-dialog">



      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <h3>{{ $category2->title ?? ''  }}</h3>

        <div class="modal-body">

          <form action="{{ url('/admin/category_web')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <input type="hidden" name="category2_data" value="{{$category2->id ?? '' }}">



            <label>Title</label>

            <input type="text" name="title" class="form-control" value="{{$category2->title ?? '' }}">



            <label>Title French</label>

            <input type="text" name="fr_title" class="form-control" value="{{$category2->fr_title ?? '' }}">



            <label>Description</label>

            <input type="text" name="description" class="form-control" value="{{$category2->description ?? '' }}">

            

            <label>Description French</label>

            <input type="text" name="fr_description" class="form-control" value="{{$category2->fr_description ?? '' }}">



            <div class="modal-footer">

              <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

            </div>

          </form>

        </div>

      </div>



    </div>

  </div>









  <div class="modal fade" id="myservice" role="dialog" align="center">

    <div class="modal-dialog">

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <h3>{{ $category3->title ?? '' }}</h3>

        <div class="modal-body">

          <form action="{{ url('/admin/category_web')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <input type="hidden" name="category3_data" value="{{$category3->id ?? '' }}">



            <label>Title</label>

            <input type="text" name="title" class="form-control" value="{{$category3->title ?? '' }}">



            <label>Title French</label>

            <input type="text" name="fr_title" class="form-control" value="{{$category3->fr_title ?? '' }}">



            <label>Description</label>

            <input type="text" name="description" class="form-control" value="{{$category3->description ?? '' }}">



            <label>Description French</label>

            <input type="text" name="fr_description" class="form-control" value="{{$category3->fr_description ?? '' }}">



            <div class="modal-footer">

              <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

            </div>

          </form>

        </div>

      </div>



    </div>

  </div>







  <div class="modal fade" id="mytitle" role="dialog" align="center">

    <div class="modal-dialog">



      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <h3>{{ $category3->title ?? ''}}</h3>

        <div class="modal-body">

          <form action="{{ url('/admin/category_web')}}" method="POST" enctype="multipart/form-data" align="left">

            @csrf

            <input type="hidden" name="category4_data" value="{{$category4->id ?? '' }}">



            <label>Title</label>

            <input type="text" name="title" class="form-control" value="{{$category4->title ?? '' }}">



            <label>Title French</label>

            <input type="text" name="fr_title" class="form-control" value="{{$category4->fr_title ?? '' }}">



            <label>Description</label>

            <input type="text" name="description" class="form-control" value="{{$category4->description ?? '' }}">



            <label>French Description</label>

            <input type="text" name="fr_description" class="form-control" value="{{$category4->fr_description ?? '' }}">



            <div class="modal-footer">

              <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>

            </div>

          </form>

        </div>

      </div>



    </div>

  </div>

</div>



@endsection



@section('script')





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>







@endsection