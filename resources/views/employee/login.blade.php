<!doctype html>
<html lang="en">
    <head>
      	<title>Employees Portal</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    	<link href="{{asset('assets/franchisee/css/style.css')}}" rel="stylesheet" type="text/css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    	<style type="text/css">
            .error{color:red;}
            
            :root .open {
            	--transform-value: -100%;
                --animation-duration:2s;
            	--animation-ease: ease-in;
            }
            .curtain div::after {
                content: "";
               /* background: url(https://abacus.mytura.in/assets/franchisee/images/frill-top.png);*/
                height: 120px;
                top: 0;
                left: 0;
                width: 100%;
                position: absolute;
                background-size: 600px;
            }
            .curtain:hover{cursor:pointer;}
            .curtain .left img,.curtain .right img  {
                height:80%;
            }
            .curtain .left {
                text-align: left;
            }
            .curtain .right{text-align:right;}
            .curtain::before {
                position: absolute;
                z-index: 9999999;
                width: 100%;
                height: 100%;
                background-image: url(https://abacus.mytura.in/assets/franchisee/images/welcome.png);
                left: 0;
                top: 0;
                content: "";
                background-size:35%;
                background-repeat: no-repeat;
                background-position: center;
            	  animation-duration: 1s;
                animation-fill-mode: both;
            }
            
            @keyframes animatebottom{from{top:0px;opacity:0} to{top:-100%;opacity:1}}
            .curtain.open::before {
                /* display: none; */
                animation: animatebottom 1s;
                top: -100%;
            }
            @keyframes initialAnimation-horizontal {
                from {
                    transform: translateX(0)
                }
                to {
                    transform: translateX(var(--transform-value));
                }
            }
            
            [data-animation*='first'] div:first-child, [data-animation*='first'] div:last-child {
            	position: fixed;
            	width: 50vw;
            	height: 100vh;
                top: 0;
                border: 0;
            	background: linear-gradient(to right, #a90329 0%,#a90329 6%,#6d0019 10%,#a90329 14%,#a90329 20%,#6d0019 24%,#a90329 28%,#a90329 34%,#6d0019 38%,#a90329 42%,#a90329 48%,#6d0019 52%,#a90329 56%,#a90329 62%,#6d0019 66%,#a90329 70%,#a90329 76%,#6d0019 80%,#a90329 84%,#a90329 90%,#6d0019 94%,#a90329 98%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                z-index: 123456;
            }
            
            [data-animation*='first'] div:first-child {
                left: 0;
                animation: var(--animation-duration) 
            	var(--animation-ease) 
            	var(--animation-duration) 1 forwards 
            	initialAnimation-horizontal;
            	z-index: 999999;
            }
            [data-animation*='first'] div:last-child {
                right: 0;
                --transform-value: 100%;
                animation: var(--animation-duration) 
            	var(--animation-ease) 
            	var(--animation-duration) 1 forwards 
            	initialAnimation-horizontal;
            	z-index: 999999;
            }

    	</style>
    </head>
	<body id="login">
    	<!--<div class="curtain" data-animation='first'>-->
    	<!--	<div class="left"><img src="https://abacus.mytura.in/assets/franchisee/images/left-1.png" alt="img" /></div>-->
    	<!--	<div class="right"><img src="https://abacus.mytura.in/assets/franchisee/images/right-1.png" alt="img" /></div>-->
     <!--   </div>-->

	
    	<section class="ftco-section">
    		<div class="container">
    			<div class="row justify-content-center">
    				<div class="col-md-12 text-center mb-5">
    					<h2 class="heading-section">Xpertidea pvt ltd </h2>
    					<h4 class="heading-section">Employees Portal</h4>
    				</div>
    			</div>
    			<div class="row justify-content-center">
    				<div class="col-md-12 col-lg-10">
    					<div class="wrap d-md-flex">
    						<div class="img" style="background-image: url({{asset('assets/franchisee/images/employee.jpg')}});"></div>
        					<div class="login-wrap form-box p-4 p-md-5">
        			      	    <div class="d-flex">
        			      		    <div class="w-100">
        			      			    <h4 class="mb-4"><b>Employee Login</b></h4>
        			      		    </div>
        								<!-- <div class="w-100">
        									<p class="social-media d-flex justify-content-end">
        										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
        										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
        									</p>
        								</div> -->
        			      	    </div>
        			      	    
        			      	    @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{session('success')}}
                                    </div>
								@elseif(session('error'))
									<div class="alert alert-danger" role="alert">
                                        {{session('error')}}
                                    </div>
                                @endif
        						<form action="{{ route('employeeLoginPost') }}" method="POST" class="signin-form">
        						    @csrf
                                    @method("POST")
        						    <div class="form-group ">
            			      			<label class="label">Email</label>
            			      			<input type="text" name="official_email" class="form-control" placeholder="official email">
            			      		</div>

                		            <div class="form-group mb-3">
                		            	<label class="label">Password</label>
                		                <input type="password" name="password" class="form-control" placeholder="Password" id="pass">
                		                <a class="text-dark" id="icon-click"><i class="fa fa-eye-slash" id="icon"></i></a>
                		                <!--<i class="far fa-eye text-muted" id="togglePassword" style="cursor: pointer;"></i>-->
                		            </div>

                		            <div class="form-group row mt-3">
                		            	<div class="col-sm-12 text-left">
                			            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                						</div>
                		            </div>
        					        
        					        <!-- <div class="form-group row">
                		            	<div class="col-sm-12 text-md-right">
										    <a href="{{ url('/franchisee/register') }}" class="text-white">
        										<button type="button" class="form-control btn btn-primary rounded px-3">
        										     Franchisee Register
        										</button>
											</a>
    									</div>
                		            </div> -->
                		            
           <!--     		            <div class="form-group row">-->
           <!--     		            	<div class="col-sm-12 text-md-right">-->
										 <!--   <a href="{{ url('/course_instructor/register') }}" class="text-white">-->
        			<!--							<button type="button" class="form-control btn btn-warning rounded px-3">-->
        			<!--							     Cousrse Instructor Register-->
        			<!--							</button>-->
											<!--</a>-->
    							<!--		</div>-->
           <!--     		            </div>-->
        					      <!--  <p class="text-center">Forgot Password? <a href="{{url('/forget_password')}}"> Click here</a></p> -->
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
<script>
    $(document).ready(function() {
    	$("#icon-click").click(function() {
    		var className = $("#icon").attr('class');
    		className = className.indexOf('slash') !== -1 ? 'fa fa-eye' : 'fa fa-eye-slash'
    
    		$("#icon").attr('class', className);
    		var input = $("#pass");
    
    		if (input.attr("type") == "text") {
    			input.attr("type", "password");
    		} else {
    			input.attr("type", "text");
    		}
    	});
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#togglePassword').on('click',function(){
            if($('#id_password').attr("type")==="password"){
                $('#id_password').attr("type","text");
            }else{
                $('#id_password').attr("type","password");
            }
        });
        
        if ($(".signin-form").length > 0) {
            $(".signin-form").validate({
                rules: {
                    official_email: 'required',
                    password: 'required'
                },
                messages: {
                    official_email: "official email field is required.",
                    password: "Password field is required."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
		
		$(".curtain").click(function(){
            $(".curtain").addClass("open");
        });
		
    });
</script>




<script>
    // var confetti = {
    //     maxCount: 150,
    //     speed: 2,
    //     frameInterval: 15,
    //     alpha: 1,
    //     gradient: !1,
    //     start: null,
    //     stop: null,
    //     toggle: null,
    //     pause: null,
    //     resume: null,
    //     togglePause: null,
    //     remove: null,
    //     isPaused: null,
    //     isRunning: null
    // };
        
    // ! function () {
    //     confetti.start = s, confetti.stop = w, confetti.toggle = function () {
    //         e ? w() : s()
    //     }, confetti.pause = u, confetti.resume = m, confetti.togglePause = function () {
    //         i ? m() : u()
    //     }, confetti.isPaused = function () {
    //         return i
    //     }, confetti.remove = function () {
    //         stop(), i = !1, a = []
    //     }, confetti.isRunning = function () {
    //         return e
    //     };
    //     var t = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window
    //         .mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame,
    //         n = ["rgba(30,144,255,", "rgba(107,142,35,", "rgba(255,215,0,", "rgba(255,192,203,", "rgba(106,90,205,",
    //             "rgba(173,216,230,", "rgba(238,130,238,", "rgba(152,251,152,", "rgba(70,130,180,",
    //             "rgba(244,164,96,", "rgba(210,105,30,", "rgba(220,20,60,"
    //         ],
    //         e = !1,
    //         i = !1,
    //         o = Date.now(),
    //         a = [],
    //         r = 0,
    //         l = null;

    //     function d(t, e, i) {
    //         return t.color = n[Math.random() * n.length | 0] + (confetti.alpha + ")"), t.color2 = n[Math.random() *
    //                 n.length | 0] + (confetti.alpha + ")"), t.x = Math.random() * e, t.y = Math.random() * i - i, t
    //             .diameter = 10 * Math.random() + 5, t.tilt = 10 * Math.random() - 10, t.tiltAngleIncrement = .07 *
    //             Math.random() + .05, t.tiltAngle = Math.random() * Math.PI, t
    //     }

    //     function u() {
    //         i = !0
    //     }

    //     function m() {
    //         i = !1, c()
    //     }

    //     function c() {
    //         if (!i)
    //             if (0 === a.length) l.clearRect(0, 0, window.innerWidth, window.innerHeight), null;
    //             else {
    //                 var n = Date.now(),
    //                     u = n - o;
    //                 (!t || u > confetti.frameInterval) && (l.clearRect(0, 0, window.innerWidth, window.innerHeight),
    //                     function () {
    //                         var t, n = window.innerWidth,
    //                             i = window.innerHeight;
    //                         r += .01;
    //                         for (var o = 0; o < a.length; o++) t = a[o], !e && t.y < -15 ? t.y = i + 100 : (t
    //                             .tiltAngle += t.tiltAngleIncrement, t.x += Math.sin(r) - .5, t.y += .5 * (Math
    //                                 .cos(r) + t.diameter + confetti.speed), t.tilt = 15 * Math.sin(t.tiltAngle)
    //                         ), (t.x > n + 20 || t.x < -20 || t.y > i) && (e && a.length <= confetti
    //                             .maxCount ? d(t, n, i) : (a.splice(o, 1), o--))
    //                     }(),
    //                     function (t) {
    //                         for (var n, e, i, o, r = 0; r < a.length; r++) {
    //                             if (n = a[r], t.beginPath(), t.lineWidth = n.diameter, i = n.x + n.tilt, e = i + n
    //                                 .diameter / 2, o = n.y + n.tilt + n.diameter / 2, confetti.gradient) {
    //                                 var l = t.createLinearGradient(e, n.y, i, o);
    //                                 l.addColorStop("0", n.color), l.addColorStop("1.0", n.color2), t.strokeStyle = l
    //                             } else t.strokeStyle = n.color;
    //                             t.moveTo(e, n.y), t.lineTo(i, o), t.stroke()
    //                         }
    //                     }(l), o = n - u % confetti.frameInterval), requestAnimationFrame(c)
    //             }
    //     }

    //     function s(t, n, o) {
    //         var r = window.innerWidth,
    //             u = window.innerHeight;
    //         window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame ||
    //             window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window
    //             .msRequestAnimationFrame || function (t) {
    //                 return window.setTimeout(t, confetti.frameInterval)
    //             };
    //         var m = document.getElementById("confetti-canvas");
    //         null === m ? ((m = document.createElement("canvas")).setAttribute("id", "confetti-canvas"), m
    //             .setAttribute("style", "display:block;z-index:999999;pointer-events:none;position:fixed;top:0"),
    //             document.body.prepend(m), m.width = r, m.height = u, window.addEventListener("resize",
    //                 function () {
    //                     m.width = window.innerWidth, m.height = window.innerHeight
    //                 }, !0), l = m.getContext("2d")) : null === l && (l = m.getContext("2d"));
    //         var s = confetti.maxCount;
    //         if (n)
    //             if (o)
    //                 if (n == o) s = a.length + o;
    //                 else {
    //                     if (n > o) {
    //                         var f = n;
    //                         n = o, o = f
    //                     }
    //                     s = a.length + (Math.random() * (o - n) + n | 0)
    //                 }
    //         else s = a.length + n;
    //         else o && (s = a.length + o);
    //         for (; a.length < s;) a.push(d({}, r, u));
    //         e = !0, i = !1, c(), t && window.setTimeout(w, t)
    //     }

    //     function w() {
    //         e = !1
    //     }
    // }();
        
    // // custom js
    // confetti.start();

</script>
