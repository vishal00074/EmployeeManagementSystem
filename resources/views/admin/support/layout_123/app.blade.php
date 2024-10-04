<!doctype html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
      	@include('employee.include.head')
    </head>
	<body id="login">
	    
        <section class="ftco-section">
    		<div class="container">
    			<div class="row justify-content-center">
    				<div class="col-md-12 text-center mb-1">
    					<h2 class="heading-section">XpertIdea pvt ltd</h2>
    					<h4 class="heading-section">Admin Portal</h4>
    				</div>
    			</div>
                
                @yield('content')
                
            </div>
    	</section>
        
        @include('employee.include.footer')
        
        <!--<script src="js/jquery.min.js"></script>-->
        <!--<script src="js/popper.js"></script>-->
        <!--<script src="js/bootstrap.min.js"></script>-->
        <!--<script src="js/main.js"></script>-->
        <script>
            var base_url = `<?php echo URL::to('/');?>`;
            var asset_url = `<?php echo URL::to('/');?>`;
            $(document).ready(function(){
                var success = `<?php echo Session::get('success'); ?>`;
                    if(success){
                        notify('success',success)
                    }
                    
                var error = `<?php echo Session::get('error'); ?>`;
                    if(error){
                        notify('error',error)
                    }
            });
            var swalInit = swal.mixin({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-light'
            });
        </script>
        @yield('script')
	</body>
</html>
