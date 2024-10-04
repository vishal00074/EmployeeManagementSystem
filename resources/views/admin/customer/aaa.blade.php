@extends('admin.customer.order-list.app')
@section('content')

<!-- Content area  -->
<div class="content">
    <div class="col-sm-6 mb-1" align="">
        <button type="button" class="btn btn-success btn-sm">
            <a href="{{ url('/admin/order_list')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
        </button>
    </div>
    
    <div class="mb-4">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-1">
            <img src="{{ asset('/public/assets/admin/img/all-orders.png')}}" alt="">
            Order details
        </h2>
    </div>

    <div class="row gy-3" id="printableArea">
        <div class="col-lg-8 col-xl-9">
            <div class="card h-100" style="padding: 0 !important;">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
                        <div class="d-flex flex-column gap-10">
                            <h4 class="text-capitalize heading">Order ID #{{$data->order_id}}</h4>
                            <div class="calendar">
                                <img style=" height: 16px; width: 15px;" src="{{ asset('/public/assets/admin/img/calendar.png')}}" alt="">
                                {{$data->created_at}}
                            </div>
                            <div class="card-box  badge-soft-info font-weight-bold d-flex align-items-center rounded py-1 px-2">
                                <div class="link"> Linked orders (2) : </div>
                                <a href="#" class="btn btn-info link-btn">100182</a>
                                <a href="#" class="btn btn-info link-btn">100183</a>
                            </div>
                        </div>
                        <div class="text-sm-right">
                            <div class="d-flex flex-wrap gap-10">
                                <div class="">
                                    <button class="btn btn--primary px-4 link-btn" data-toggle="modal" data-target="#locationModal"><i class="tio-map"></i> Show locations on map</button>
                                </div>
                                <a class="btn btn--primary px-4 link-btn" target="_blank" href="#">
                                    <i class="tio-print mr-1"></i> Print Invoice
                                </a>
                            </div>
                            <div class="d-flex flex-column gap-2 mt-3">
                                <div class="order-status d-flex justify-content-sm-end gap-10 text-capitalize">
                                    <span class="title-color">Status: </span>
                                    <span class="badge badge-soft-info font-weight-bold radius-50 d-flex align-items-center py-1 px-2" style="padding: 0 !important;" value="1">
                                        @if($data->order_status == '0')
                                            Pending
                                        @elseif($data->order_status == '1')
                                            In Progress
                                        @elseif($data->order_status == '2')
                                            Delivered
                                        @elseif($data->order_status == '3')
                                            Completed
                                        @elseif($data->order_status == '4')
                                            Declined
                                        @endif
                                    </span>
                                </div>

                                <div class="payment-method d-flex justify-content-sm-end gap-10 text-capitalize">
                                    <span class="title-color">Payment Method :</span>
                                    <strong>Cash on delivery</strong>
                                </div>

                                <div class="payment-status d-flex justify-content-sm-end gap-10">
                                    <span class="title-color">Payment Status:</span>
                                    <span class="text-danger font-weight-bold">
                                        @if($data->status == '0')
                                            Paid
                                        @elseif($data->status == '1')
                                            Unpaid
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive datatable-custom">
                        <table class="table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>SL</th>
                                    <th>Item Details</th>
                                    <th>Variations</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>
                                        <div class="media align-items-center gap-10">
                                            <img class="avatar avatar-60 rounded" style="height: 60px; width: 60px;" : src="{{$data->Prmary_Image}}" alt="Image Description">
                                            <div>
                                                <h6 class="title-color">{{$data->product_name}}</h6>
                                                <div><strong>Price :</strong> XOF {{$data->Price}}</div>
                                                <div><strong>Qty :</strong> 1</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$data->ColorName}}</td>
                                    <td>XOF 25.0</td>
                                    <td>XOF {{$data->discount}}</td>
                                    <td>XOF 475.0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row justify-content-md-end total">
                        <div class="col-md-9 col-lg-8">
                            <dl class="row gy-1 text-sm-right">
                                <dt class="col-5">Shipping</dt>
                                <dd class="col-6 title-color">
                                    <strong>XOF {{$data->shipping_charge}}</strong>
                                </dd>
                                <dt class="col-5">Coupon discount</dt>
                                <dd class="col-6 title-color">
                                    {{$data->discount}}
                                </dd>
                                <dt class="col-5"><strong>Total</strong></dt>
                                <dd class="col-6 title-color">
                                    <strong>XOF {{$data->total_amount}}</strong>
                                </dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-3 d-flex flex-column gap-3 right-box">
            <div class="card" style="padding: 0 !important;">
                <div class="card-body text-capitalize d-flex flex-column gap-4 box-content">
                    <h4 class="mb-0 text-center">Order &amp; Shipping Info</h4>
                    <div class="">
                        <form action="{{ url('/admin/order_status')}}/{{$order->id}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Order</label>
                                <select name="order_status" onchange="order_status(this.value)" class="status form-control" data-id="100184">
                                    <option selected value="0" {{$data->order_status == "0" ? "selected" : "" ;}}>Pending</option>
                                    <option value="1" {{$data->order_status == "1" ? "selected" : "" ;}}>In Progress</option>
                                    <option value="2" {{$data->order_status == "2" ? "selected" : "" ;}}>Delivered</option>
                                    <option value="3" {{$data->order_status == "3" ? "selected" : "" ;}}>Completed</option>
                                    <option value="4" {{$data->order_status == "4" ? "selected" : "" ;}}>Declined</option>
                                </select>
                            </div>
                    <!--</div>-->
                            <div class="">
                                <label class="font-weight-bold title-color fz-14">Payment Status</label>
                                <select name="status" onchange="status(this.value)" class="payment_status form-control" data-id="100184">                          
                                    <option value="0" href="javascript:"  {{$data->status == "0" ? "selected" : "" ;}}>Paid</option>
                                    <option value="1" selected="" {{$data->status == "1" ? "selected" : "" ;}}>Unpaid</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Status</button>
                        </form>
                    </div>
                    
                    <ul class="list-unstyled list-unstyled-py-4">
                        <li>
                            <label class="font-weight-bold title-color fz-14">
                                Shipping type
                                (Order wise)
                            </label>
                            <label class="font-weight-bold title-color fz-14">
                                Shipping Method
                                (Order wise shipping)
                            </label>
                            <select class="form-control text-capitalize" name="delivery_type" onchange="choose_delivery_type(this.value)">
                                <option value="0">
                                    Choose delivery type
                                </option>
                                <option value="self_delivery">
                                    By self delivery man
                                </option>
                                <option value="third_party_delivery">
                                    By third party delivery service
                                </option>
                            </select>
                        </li>
                        <li class="choose_delivery_man" style="display: none;">
                            <label class="font-weight-bold title-color fz-14">
                                Choose delivery man
                            </label>
                            <select class="form-control text-capitalize js-select2-custom select2-hidden-accessible" name="delivery_man_id" onchange="addDeliveryMan(this.value)" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="0" data-select2-id="3">Select</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span class="select2-selection custom-select" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-delivery_man_id-dl-container"><span class="select2-selection__rendered" id="select2-delivery_man_id-dl-container" role="textbox" aria-readonly="true" title="Select"><span>Select</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                        </li>
                        <li class="choose_delivery_man" style="display: none;">
                            <label class="font-weight-bold title-color fz-14">
                                Deliveryman will get (XOF)
                            </label>
                            <input type="number" id="deliveryman_charge" onkeyup="amountDateUpdate(this, event)" value="0" name="deliveryman_charge" class="form-control" placeholder="Ex: 20" required="">
                        </li>
                        <li class="choose_delivery_man" style="display: none;">
                            <label class="font-weight-bold title-color fz-14">
                                Expected delivery date
                            </label>
                            <input type="date" onchange="amountDateUpdate(this, event)" value="" name="expected_delivery_date" id="expected_delivery_date" class="form-control" required="">
                        </li>
                        <li class=" mt-2" id="by_third_party_delivery_service_info" style="display: none;">
                            <span>
                                Delivery service name :
                            </span>
                            <span class="float-right">
                                <a href="javascript:" onclick="choose_delivery_type('third_party_delivery')">
                                    <i class="tio-edit"></i>
                                </a>
                            </span>
                            <br>
                            <span>
                                Tracking id :
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card" style="padding: 0 !important;">
                <div class="card-body">
                    <h4 class="mb-4 d-flex gap-2 customer">
                        <img style="height: 19px; width: 19px;" : src="{{ asset('/public/assets/admin/img/seller-information.png')}}" alt="">
                        Customer information
                    </h4>
                    <div class="media gap-3">
                        <div class="">
                            <img style="border-radius: 37px; height: 70px; width: 70px;" : src="{{$data->profile_image}}" alt="">
                        </div>
                        <div class="media-body d-flex flex-column gap-1" style="width: 10px; margin-left: 10px;">
                            <span class="title-color"><strong>{{$data->name}}</strong></span>
                            <span class="title-color"> <strong>3</strong> Orders</span>
                            <span class="title-color break-all"><strong>{{$data->phone_number}}</strong></span>
                            <span class="title-color break-all">{{$data->email}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="padding: 0 !important;">
                <div class="card-body">
                    <h4 class="mb-4 d-flex gap-2 customer">
                        <img style="height: 19px; width: 19px;" : src="{{ asset('/public/assets/admin/img/seller-information.png')}}" alt="">
                        Shipping address
                    </h4>
                    <div class="d-flex flex-column gap-2 shipping">
                        <div>
                            <span>Name :</span>
                            <strong>{{$data->full_name}}</strong>
                        </div>
                        <div>
                            <span>Contact:</span>
                            <strong>{{$data->mobile_no}}</strong>
                        </div>
                        <div>
                            <span>City:</span>
                            <strong>{{$data->city}}</strong>
                        </div>
                        <div>
                            <span>Zip code :</span>
                            <strong>{{$data->postcode}}</strong>
                        </div>
                        <!-- <div class="d-flex align-items-start gap-2">
                            <img style="width: 19px;" : src="{{ asset('/public/assets/admin/img/10-location.png')}}" alt="">
                            city
                        </div> -->
                    </div>
                </div>

            </div>

            <div class="card" style="padding: 0 !important;">
                <div class="card-body">
                    <h4 class="mb-4 d-flex gap-2 customer">
                        <img style="height: 19px; width: 19px;" : src="{{ asset('/public/assets/admin/img/shop-information.png')}}" alt="">
                        Shop Information
                    </h4>
                    <div class="media">
                        <div class="mr-3">
                            <img style="height: 70px; width: 70px;" : src="{{ asset('/public/assets/admin/img/2022-04-21-6260f38e9ce54.png')}}" alt="">
                        </div>
                        <div class="media-body d-flex flex-column gap-2 shop">
                            <h5>Wellness Fair</h5>
                            <span class="title-color"><strong>2</strong> Orders Served</span>
                            <span class="title-color"> <strong>0188</strong></span>
                            <div class="d-flex align-items-start gap-2">
                                <img style="width: 16px;" : src="{{ asset('/public/assets/admin/img/10-location.png')}}" alt="">
                                dhaka
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-5 mb-1" align="left">
                <h6 class="card-title"><b>Invoice</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <button type="button" class="btn btn-success btn-sm">
                    <a href="{{ url('/admin/order_list')}}" class="text-white"> <i class="icon-circle-left2 mr-1"></i> Back</a>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5"> -->
    <!-- <address>
                    <strong>Billing Information:</strong><br>
                    fd wqe<br>
                    dfshg@gmail.com<br>
                    000000000000<br>
                    dsfhg,
                    London, England, United Kind<br>
                </address> -->
    <!-- </div>
            <div class="col-md-5 text-md-right">
                <address>
                    <strong style="font-weight: 800;">Shipping Information :</strong><br>
                    Sed et error eligend Minim aut molestiae<br>
                    Et labore exercitati<br>
                    Deserunt beatae ulla<br>
                    Aliquip accusantium,
                    Gandhinagar, Gujarat, India<br>
                </address>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-5 text-md-left">
                <address>
                    <strong style="font-weight: 800;">Payment Information:</strong><br>
                    Method: Cash on Delivery<br>
                    Status : <span class="badge badge-danger">Pending</span>
                    <br>
                    Transaction: <p>cash_on_delivery</p>
                </address>
            </div>
            <div class="col-md-5 text-md-right">
                <address>
                    <strong style="font-weight: 800;">Order Information:</strong><br>
                    Date: 23 November, 2022<br>
                    Shipping: free shipping<br>
                    Status :
                    <span class="badge badge-danger">Pending</span>
                </address>
            </div>
        </div>
        <div class="col-md-12 text-md-right">
            <div class="col-md-12">
                <div class="section-title">
                    <h2> Order Summary</h2>
                </div>
                <div class="table-responsive">

                    <table class="table table-striped table-hover ">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Product</th>
                            <th width="20%">Variant</th>
                            <th width="20%">Shop Name</th>
                            <th width="20%" class="text-center">Price</th>
                            <th width="20%" class="text-center">Quantity</th>
                            <th width="20%" class="text-right">Total</th>
                        </tr>

                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->product_name}}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">{{$data->Price}}</td>

                            <td class="text-center">1</td>
                            <td class="text-right">{{$data->total_amount}}</td>
                        </tr>

                    </table>
                </div>
                <br><br>

                <div class="row">

                    <div class="col-md-5 text-md-left">
                        <div class="section-title"><h1> Order Status </h1></div>

                        <form action="{{ url('/admin/order_status')}}/{{$order->id}}" method="POST">

                        @csrf -->
    <!-- <input type="hidden" name="_token" value="husElo27Pw2X22J6TXHJR6V36mxPDKfsfhPonD2l"> <input type="hidden" name="_method" value="PUT"> -->
    <!-- <div class="form-group">
                                <label for="">Payment</label>
                                <select name="payment_status" id="" class="form-control">
                                    <option selected value="0">Pending</option>
                                    <option value="1">Success</option>
                                </select>
                            </div> -->

    <!-- <div class="form-group">
                                <label for="">Order</label>
                                <select name="order_status" id="" class="form-control">
                                    <option selected value="0">Pending</option>
                                    <option value="1">In Progress</option>
                                    <option value="2">Delivered</option>
                                    <option value="3">Completed</option>
                                    <option value="4">Declined</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" type="submit">Update Status</button>
                        </form>
                    </div>
                
            <div class="col-lg-6 text-right">
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Subtotal : {{$data->Price}}</div>
                </div>
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Discount(-) : {{$data->discount}}</div>
                </div>
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Shipping : {{$data->shipping_charge}}</div>
                </div>

                <hr class="mt-2 mb-2">
                <div class="invoice-detail-item">
                    <div class="invoice-detail-value invoice-detail-value-lg">
                        <h2> Total : {{$data->product_total}}</h2>
                    </div>
                </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    
    </div>
</div> -->
<!-- /page length options  -->

@endsection

@section('script')
<script src="{{asset('public/assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('public/assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".UOMDetails").length > 0) {
            $(".UOMDetails").validate({
                rules: {
                    Description: "required",
                    UnitOfMeasurementSymbol: "required",
                    Status: "required"
                },
                messages: {
                    Description: "UOM Description field is required.",
                    UnitOfMeasurementSymbol: "Abbreviation field is required.",
                    Status: "Status field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
@endsection