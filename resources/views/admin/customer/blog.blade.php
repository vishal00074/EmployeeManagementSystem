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
                   
                    <form  method="post" action="">
                         @csrf
                    </form>
              
              <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/addblog')}}" class="btn btn-success rounded float-left">ADD</a><br><br>
                    </div>
              
              
                
          <table id="user-list-table" class="table table-striped table-bordered mt-4 sta" role="grid" aria-describedby="user-list-page-info">
             <thead>
            <style>
                table, th, td {
                  border: 1px solid black;
                     padding: 10px;
                }
                </style>



                 <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
             </tr>
            
         </thead>
         <tbody>
                           @foreach ($detail as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                               <td>{{$user->description}}</td>
                              <td><img src="{{ asset('public/users/'.$user->image) }}" width="120px"></td>
                               <td>
                                   <a href="{{url('/admin/bloglist/content/'.$user->id)}}" class="btn mb-3 btn-success rounded">Add Content</a>
                                   <a href="{{url('/admin/bloglist/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/bloglist/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                                </td>
                                </tr>
                                
                          @endforeach
                             </tbody>
                         </table>
                         
                         </div>
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
                   
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection


