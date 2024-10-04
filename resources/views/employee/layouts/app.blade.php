<!doctype html>
<html lang="en">

<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/xpertidea_logo.png') }}">
	@include('employee.include.head')
	<style>

	</style>

</head>

<body id="login">
	@include('employee.include.header')
	

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 text-center mb-1">
					<h2 class="heading-section">XpertIdea pvt ltd</h2>
					<h4 class="heading-section">Employee Portal</h4>
				</div>
			</div>

			@yield('content')

		</div>
	</section>

	@include('employee.include.footer')


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".menu-btn,.sidebar-mobile-main-toggle").click(function() {
				$(".sidebar-expand-md").toggleClass("visible");
			});


			$('body').on('click', '.sing-in', function() {
				swalInit.fire({
					title: 'Sign In',
					html: `
            <input id="remark" type="text" class="form-control" placeholder="Remark" required>
        `,
					showCancelButton: true,
					confirmButtonText: 'Submit',
					cancelButtonText: 'Cancel',
					confirmButtonClass: 'btn btn-success',
					cancelButtonClass: 'btn btn-danger',
					buttonsStyling: false,
				}).then(function(result) {
					if (result.value) {
						var remark = $('#remark').val();
						
						$.ajax({
							type: 'GET',
							url: "{{ url('employee/sign-in') }}",
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							data: {
								remark: remark
							},
							success: function(response) {

								if (response.status == true) {
									swalInit.fire({
										title: 'Signed In',
										text: 'Time In has been saved.',
										type: 'success'
									}).then((willDelete) => {
										location.reload();
									});
								} else {
									swalInit.fire({
										title: 'Error updating Time In!',
										text: response.message,
										type: 'error'
									}).then((willDelete) => {
										location.reload();
									});
								}

							},
							error: function(response) {
								swalInit.fire({
									title: 'Error updating Time In!',
									text: 'Please try again!',
									type: 'error'
								}).then((willDelete) => {
									location.reload();
								});
							}
						});
					}
				});
			});
		});
	</script>
	<script>
		var base_url = `<?php echo URL::to('/'); ?>`;
		var asset_url = `<?php echo URL::to('/'); ?>`;
		$(document).ready(function() {
			var success = `<?php echo Session::get('success'); ?>`;
			if (success) {
				notify('success', success)
			}

			var error = `<?php echo Session::get('error'); ?>`;
			if (error) {
				notify('error', error)
			}
		});
		var swalInit = swal.mixin({
			buttonsStyling: false,
			confirmButtonClass: 'btn btn-primary',
			cancelButtonClass: 'btn btn-light'
		});
	</script>
	<script>
		// Calling showTime function at every second
		setInterval(showTime, 1000);

		// Defining showTime funcion
		function showTime() {
			// Getting current time and date
			let time = new Date();
			let hour = time.getHours();
			let min = time.getMinutes();
			let sec = time.getSeconds();
			am_pm = "AM";

			// Setting time for 12 Hrs format
			if (hour >= 12) {
				if (hour > 12) hour -= 12;
				am_pm = "PM";
			} else if (hour == 0) {
				hr = 12;
				am_pm = "AM";
			}

			hour =
				hour < 10 ? "0" + hour : hour;
			min = min < 10 ? "0" + min : min;
			sec = sec < 10 ? "0" + sec : sec;

			let currentTime =
				hour +
				":" +
				min +
				":" +
				sec +
				am_pm;

			// Displaying the time
			document.getElementById(
				"clock"
			).innerHTML = currentTime;
		}

		showTime();
	</script>
	
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCXZkh0PnC5vmwA5Aq8muqThPfBSfdR-tw",
            authDomain: "laravel-aa589.firebaseapp.com",
            projectId: "laravel-aa589",
            storageBucket: "laravel-aa589.appspot.com",
            messagingSenderId: "250691320881",
            appId: "1:250691320881:web:cb451d506e847d53ace910",
            measurementId: "G-R32HXZX6R8"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function() {
                return messaging.getToken()
            }).then(function(token) {

                axios.post("{{ route('fcmToken') }}", {
                    _method: "PATCH",
                    token
                }).then(({
                    data
                }) => {
                    console.log(data)
                }).catch(({
                    response: {
                        data
                    }
                }) => {
                    console.error(data)
                })

            }).catch(function(err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();

        messaging.onMessage(function({
            data: {
                body,
                title
            }
        }) {
            new Notification(title, {
                body
            });
        });
    </script>


	@yield('script')
</body>

</html>