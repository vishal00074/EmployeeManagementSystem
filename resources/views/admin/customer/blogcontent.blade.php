@extends('admin.customer.extra.app')


@section('content')
 <!-- Content area  -->
 <div class="content">
     <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
        	<div class="col-sm-6 mb-1" align="left">
			    <h6 class="card-title"><b>Add Details</b></h6>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>
        @endif
        
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-6">
               
                    <form id="formData" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="blog_id"  id="blog_id" value="{{ $blog->id }}"> 
                        @csrf
                        <!--<h4><b>Add Details</b></h4>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value=""> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea type="text" class="form-control" id="content" name="content" value=""></textarea> 
                                </div>
                            </div>
                            
                          
                           <div class="form-group">
                                <label for="">Image</label><br>
                                <input type="file"  id="image"  name ="image" value="">
                            </div>  
                            
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-3">
                <!-- <h5 class="ml-2 mb-0">
                   <a href=""><button type="button" class="btn btn-primary btn-sm" ><i class="icon-plus-circle2 mr-2"></i> Add</button></a>
               </h5> -->
            </div>
        </div>

        <table  class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

              

            </tbody>
        </table>
    </div>
   
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#image').change(function() {
        var file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });

    $(".btn-primary").click(function(e) {

        e.preventDefault();

        var formData = new FormData();
        formData.append('title', $("#title").val());
        formData.append('image', $('#image')[0].files[0]);
        formData.append('content', $("#content").val());
        formData.append('blog_id', $("#blog_id").val());

        $.ajax({
            type: 'POST',
            url: "{{ url('admin/add/blogcontent') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    alert(data.success);
                   location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>

<script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/admin/bloglist/content/'.$blog->id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            
            {data: 'image', name: 'image', render: function(data, type, full, meta) {
        return '<img src="' + data + '" width="100" height="100">';
    }},
           
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>



@endsection