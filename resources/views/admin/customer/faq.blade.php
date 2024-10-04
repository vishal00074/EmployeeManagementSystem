@extends('admin.customer.extra.app')


@section('content')
 
<div class="content">
    <div class="card">
        <div class="card-body"> 
              <div class="container-fluid">
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                             </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                         
                    <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/addfaqdetail')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
                    </form>
                    
                <h4>FAQ Details</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($Faq as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                               <td>{{$user->description}}</td>
                               <td>
                                  
                                    <a href="{{url('/admin/faqlist/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
                </div>
            
            
            
        <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                     <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/adddetail')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Frequently Asked Question</h4>
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
                    <th>Whatsaap</th>
                    <th>By Phone</th>
                    <th>Online</th>
                    <th>Live Chat</th>
                    <th>Facebook Chat</th>
                    <th>By Email</th>
                    <th>Skype Call</th>
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($Faq1 as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <th>{{$user->whatsapp}}</th>
                               <td>{{$user->byphone}}</td>
                               <td>{{$user->online}}</td>
                               <td>{{$user->livechat}}</td>
                               <td>{{$user->facebookchat}}</td>
                               <td>{{$user->email}}</td>
                               <th>{{$user->skypecall}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist1/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist1/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
                 </div>
         
         
         
          <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                       <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/addlist')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Faq Title</h4>
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
                    <th>FaqTitle</th>
                    <th>FaqDescription</th>
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($Faq2 as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->faqtitle}}</td>
                              <th>{{$user->faqdescription}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist2/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist2/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
                   </div>
                 
       
      
        <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                      <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/faqservice')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Faq Services</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($Faq3 as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist3/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist3/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
      
      </div>
      
          <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                    
                       <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/faqrefund')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Refund Information</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($refund as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist8/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist8/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
      
      </div>
        
        
        <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                    <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/faqdelivery')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
                    
                    
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Delivery Information</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($delivery as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist4/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist4/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
        </div>
        
        
        
         <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                    <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/ordertracking')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
              
              
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Order Tracking </h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($ordertracking as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist7/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist7/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
        
           </div>
           
           
         <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
              
                     <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/payment')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Payment Information</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($pay as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist6/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                  <a href="{{url('/admin/faqlist6/destroy/'.$user->id)}}"  class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
        </div>
        
        
        
        
        <div class="content">
        <div class="card">
            <div class="card-body"> 
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                         </div>
                           
                  <div class="iq-card-body">
                    <div class="table-responsive">
                       <div class="row justify-content-between">
                      <div class="col-sm-6 col-md-12">
                             <div id="user_list_datatable_info" class="dataTables_filter">


                      
                    <form  method="post" action="">
                         @csrf
                    </form>
                    
                     <div class="col-sm-12 col-md-6">
                       <a href="{{url('/admin/faqmanage')}}" class="btn btn-success rounded float-left">ADD</a>
                       <br><br><br>
                    </div>
                    
              
           <form class="faqDetails" action="" method="POST">
                @csrf
                <h4>Manage Account</h4>
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
                    <th>Action</th>
             </tr>
            
             </thead>
             <tbody>
                               @foreach ($manageaccount as $user)       
                          <tr>
                             <td>{{$user->id}}</td>
                              <td>{{$user->title}}</td>
                              <th>{{$user->description}}</th>
                               <td>
                                  
                                   <a href="{{url('/admin/faqlist5/edit/'.$user->id)}}" class="btn mb-3 btn-success rounded">Edit</a>
                                   <a href="{{url('/admin/faqlist5/destroy/'.$user->id)}}" class="btn  btn-danger rounded" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
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
        </div>
        
        
        
        
        
        
        
      
    

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>


@endsection