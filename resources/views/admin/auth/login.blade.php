<!doctype html>
<html lang="en">
    <head>
      	<title>XpertIdea</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    	<link href="{{asset('assets/waamde/css/style.css')}}" rel="stylesheet" type="text/css">
    	
    	<style type="text/css">
    	    .error{
    	        color:red;
    	    }
            body#login {
                background-image: url(https://xpertidea.com/wp-content/uploads/2022/12/logo.png)!important;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                min-height: 100vh;
                position: relative;
            }
            body#login::after {
                position: absolute;
                content: "";
                width: 100%;
                height: 100%;
                background: rgb(30 121 129 / 75%);
                top: 0;
                z-index: -1;
            }
    	</style>
    </head>
	<body id="login">
    	<section class="ftco-section">
    		<div class="container">
    			<div class="row justify-content-center">
    				<div class="col-md-12 col-lg-10">
    					<div class="wrap d-md-flex">
        		            <div class="col-sm-6 text-center">
        		                <br>
        		                <br>
        		                <img src="{{ asset('assets/xpertidea_logo.png') }}" width="80%" alt="img" />
        		            </div>
        		            <div class="col-md-6 login-wrap form-box p-4 p-md-5">
        			      	    <div class="d-flex">
        			      		    <div class="w-100">
        			      			    <h4 class="mb-4"><b>Login to Your Account</b></h4>
        			      		    </div>
        			      	    </div>
        			      	    
        			      	    @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form action="{{route('adminLoginPost')}}" method="POST" class="AdminLoginForm">
        						    @csrf
									@method("POST")
        						    <div class="form-group mb-3">
            			      			<label class="label" for="name">Email</label>
            			      			<input type="email" name="email" class="form-control" placeholder="Enter your email">
            			      		</div>

                		            <div class="form-group mb-3">
                		            	<label class="label" for="password">Password</label>
                		                <input type="password" name="password" class="form-control" placeholder="Enter your password" id="pass">
                		                <a class="text-dark" id="icon-click"><i class="fa fa-eye" id="icon"></i></a>
                		            </div>

                		            <div class="form-group row">
                		            	<div class="col-sm-12 text-left"><p></p>
                			            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                						</div>
    									<!--<div class="col-sm-6 text-md-right"><p></p>-->
    									<!--	<button type="button" class="form-control btn btn-primary rounded cancel px-3">-->
    									<!--	    <a href="{{ url('/admin') }}" class="text-white">-->
    									<!--	        Cancel-->
    									<!--	    </a>-->
    									<!--	</button>-->
    									<!--</div>-->
                		            </div>
        					
        		                </form>
        		         
        		            </div>
    		            </div>
    				</div>
    			</div>
    		</div>
    	</section>
    </body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('assets/admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#icon-click").click(function() {
    		if ($('#pass').attr("type") == "password") {
    			$('#pass').attr("type", "text");
    			$("#icon").attr('class','fa fa-eye-slash');
    		} else {
    			$('#pass').attr("type", "password");
    			$("#icon").attr('class','fa fa-eye');
    		}
    	});
    
        if ($(".AdminLoginForm").length > 0) {
            $(".AdminLoginForm").validate({
                rules: {
                    email: 'required',
                    password: 'required'
                },
                messages: {
                    email: "Email field is required.",
                    password: "Password field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
</script>
