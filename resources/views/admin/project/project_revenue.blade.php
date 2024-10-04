@extends('admin.project.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">



@endsection
@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page length options -->
    <div class="card">
        <div class="row s-filter">
            <div class="col-md-8">
                <h6>Revenue Report </h6>
            </div>
            <div class="col-md-4" align="right">

                <form action="{{ url('admin/project/revenue/') }}" method="GET">
                 
                    <div class="form-group">
                        <label for="date">Select Date:</label>
                        <input type="date" name="date" class="form-control" id="date">
                    </div>
                    <button type="submit" class="btn btn-success" id="button" value="Submit">Submit</button>
                </form>
            </div>
        </div>


        <table class="table table-bordered">
            <thead>
                <tr style="background-color:black; color:aliceblue">
                    <th>S.no</th>
                    <th>Project ID</th>
                    <th>Date</th>
                    <th>Upwork Id</th>
                    <th>Project Type</th>
                    <th>Estimate Billing Hours</th>
                    <th>Estimate Billing Revenue</th>
                    <th>Total Billing Hours</th>
                    <th>Total Revenue</th>

                </tr>
            </thead>
            <tbody>
                @php $i= 0; @endphp
                @forelse($data as $item)
                @if($item->project_status == 'Completed')
                <tr style="background-color:#00e30085;">
                @elseif($item->project_status == 'Pending')
                <tr style="background-color:#f7f7009c;">
                @else
                <tr>

                @endif
                @php $i++; @endphp
                    <td>{{ $i }}</td>
                    <td>{{ $item->project_id }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->upwork_id }}</td>
                    <td>{{ $item->project_type }}</td>
                    <td>{{ $item->estimate_billing_hours }}</td>
                    <td>{{ $item->estimate_billing_amount }}</td>
                    <td>{{ $item->total_billing_hours }}</td>
                    <td>{{ $item->total_billing_amount }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">No Data Found</td>
                </tr>

                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color:black; color:aliceblue">
                    <th>Total</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>{{ $totalOfEstimateBilling }}</td>
                    <td>{{ $totalOfEstimateBillingAmount }}</td>
                    <td>{{ $FinalOfTotalBillingHours }}</td>
                    <td>{{ $FinalOfTotalBillingAmount }}</td>
                </tr>
            </tfoot>
        </table>
       
    </div>

</div>
@endsection

@section('script')
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('click', '.delete-customer', function() {
            var id = $(this).attr('data-id');
            swalInit.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'Delete',
                        url: "{{ url('admin/project_delete ') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swalInit.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                .then((willDelete) => {
                                    location.reload();
                                });
                        },
                        error: function(response) {
                            swalInit.fire(
                                'Error deleting!',
                                'Please try again!',
                                'error'
                            )
                        }
                    });
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalInit.fire(
                        'Cancelled',
                        'Your imaginary file is safe.',
                        'error'
                    )
                }
            });
        });

      
    });
</script>

@endsection