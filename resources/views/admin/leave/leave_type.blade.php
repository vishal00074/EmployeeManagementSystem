@extends('admin.leave.app')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
@endsection

@section('content')
<!-- Content area  -->
<div class="content">
    <!-- Page length options  -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="col-sm-6 mb-1" align="left">
                <h6 class="card-title"><b>Add Leave Type</b></h6>
            </div>
            <div class="col-sm-6 mb-1" align="right">
                <a class="btn btn-success" href="{{ url('admin/') }}">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('leave.type') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Leave Type</label>
                                    <input type="text" class="form-control" name="name">

                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="submit_form">Submit<i class="icon-paperplane ml-2"></i></button>
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
            </div>
            <div class="col-md-7" align="right">
            </div>
        </div>

        <table class="table get_Customer_details">
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <!-- <td><a href="{{ url('admin/leave_type/delete/') }}/{{ $type->id }}" class="btn btn-danger">Delete</a></td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $types->links() !!}
        </div>
    </div>
    <!-- /page length options -->
</div>

@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

@endsection