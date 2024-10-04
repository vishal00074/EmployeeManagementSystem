@extends('admin.customer.extra.app')


@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <!--<div class="iq-header-title">-->
                            <!--   <h4 class="card-title">Users List</h4>-->
                            <!-- </div>-->
                        </div>


                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-12">
                                        <div id="user_list_datatable_info" class="dataTables_filter">




                                            <table id="user-list-table" class="table table-striped table-bordered mt-4 sta" role="grid" aria-describedby="user-list-page-info">
                                                <thead>
                                                    <style>
                                                        table,
                                                        th,
                                                        td {
                                                            border: 1px solid black;
                                                            padding: 10px;
                                                        }
                                                    </style>

                                                    <tr>
                                                        <th><b>S.no</b></th>
                                                        <th><b>First Name</b></th>
                                                        <th><b>Last Name</b></th>
                                                        <th><b>Email</b></th>
                                                        <th><b>Phone</b></th>
                                                        <th><b>Country</b></th>
                                                        <th><b>Message</b></th>
                                                        <th><b>User Type</b></th>
                                                        <th><b>Oder Number</b></th>
                                                        <th><b>Order Description</b></th>
                                                        <th><b>Comment</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                $sno = ($data->currentPage() - 1) * $data->perPage() + 1;
                                                @endphp
                                                    @foreach ($data as $detail)
                                                    <tr>
                                                        <td>{{ $sno++ }}</td>
                                                        <td>{{$detail->firstname}}</td>
                                                        <td>{{$detail->lastname}}</td>
                                                        <td>{{$detail->email}}</td>
                                                        <td>{{$detail->phone}}</td>
                                                        <td>{{$detail->country}}</td>
                                                        <td>{{$detail->message}}</td>
                                                        <td>@if($detail->user_type == '1')
                                                            {{ "Pre Order Related Queries" }}
                                                            @else
                                                            {{ "Post Order Related Queries" }}
                                                            @endif
                                                        </td>
                                                        <td>{{$detail->order_number}}</td>
                                                        <td>{{$detail->order_description}}</td>
                                                        <td>{{$detail->comment}}</td>

                                                        <td>

                                                            <a href="{{url('/wamdequery/'.$detail->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                                                        </td>
                                                    </tr>
                                                   
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        {{ $data->links() }}
                                        <div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="content">
   
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('/admin/contentfooter',$contactfooter->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="footerservice_data" value="{{$contactfooter->id}}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h1>Footer Description</h1>
                                    <textarea class="form-control" id="description" name="description">{{$contactfooter->description}}</textarea>
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
</div> -->


@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection