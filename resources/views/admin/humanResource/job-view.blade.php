
<!DOCTYPE html>

<html>
<head><link rel="preconnect" href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/" />
    <meta charset="utf-8" />
    <base href="/careers/" id="baseHref" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/css/quill.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/css/jquery-ui/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/css/jquery-ui/theme.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.kekastatic.net/shared/icons/1.0.16/keka-icons.css" rel="stylesheet" />

        <link rel="icon" type="image/png" href="https://cdn.kekastatic.net/careers/v/2024.03.07.15/content/images/favicon.ico" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   
    <meta property="og:job_title" content="{{ $job->job_title}}">
    <meta property="og:job_description" content="{{ $job->job_description}}">




    <meta name="portalName"> 
    <style>
        .job-details-container .banner {
    background: #5faceb;
    }
    #apply-job {
        background: #5faceb !important;
    }
    .posted-info {
        text-align: right;
    }
    .social-icons a {
        font-size: 32px;
        padding: 10px 20px;
    }

    </style>
</head>
<body>
    <?//php  $id = request()->segment(3); // Retrieve the segment at index 4 (0-indexed)
        // echo $id ;
   //?>
<div class="job-details-container mb-5">
    <div class="banner mb-60">
        <div class="row justify-content-center no-gutters align-items-center max-w-1200 mx-auto h-100">
            <div class="col-md-10 col-sm-12 p-4">
                <h1 class="font-large-5 font-weight-normal m-0" >{{ $job->job_title}}</h1>({{ $job->job_position}})
                <p class="m-0 text-uppercase font-small d-flex align-items-center">
                    <span>{{ $job->company_name}}</span>&nbsp;&nbsp;&nbsp;


                    <span>
                        @if ($job->job_type == '1')
                            Full Time
                        @elseif ($job->job_type == '2')
                            Contract
                        @endif
                    </span>

                        <span class="mx-2 dot dot-xs bg-white-light"></span>

                            <span>
                                @if ($job->job_location == '1')
                                    Chandigarh
                                @elseif ($job->job_location == '2')
                                    Client Location
                                @endif
                            </span>
 
                        <span class="mx-2 dot dot-xs bg-white-light"></span>
                        <span>{{ $job->experience }} years</span>
                </p>
            </div>
        </div>
<div class="posted-info"><h3>Posted on ( {{ $job->created_at->locale('en')->diffForHumans(['short' => true]) }} )</h3> </div>

    </div>
    <div class="max-w-1200 mx-auto">
        <div class="row no-gutters justify-content-center">
            <div class="col-lg-7 col-sm-12 pr-50 mb-5">
                <div class="job-description-container ql-editor"><p><span style="color: rgb(0, 0, 0);"><h1>Job Summary:</h1></span></p><p>{{ $job->job_description}}</p><p><span style="color: rgb(0, 0, 0);"><h1>Key Responsibilities:</h1></span></p><span>{{$job->key_responsibilities }}</span><h1>Skill Required:</h1></span></p><p>{{ $job->job_skill}}</p><h1>Education:</h1></span></p><p>{{ $job->qualification}}</p><h1>Interview Mode:</h1></span></p><p>{{ $job->interview_mode}}</p><h1>Shift:</h1></span></p><p>{{ $job->shift}} shift</p></div>
                Contact us on  ({{$job->contact_detail }}), Email  ({{$job->email }})
            </div>
            <div class="col-lg-3 col-sm-12 mb-5 social-icons">
                        
             <!-- HTML code -->
                <a href="#" onclick="shareOnFacebook(event)">
                 <i class="fa fa-facebook-f"></i>

                </a>
                <a href="#" onclick="shareOnTwitter(event)">
                <i class="fa fa-twitter"></i>

                                </a>
                                <a href="#" onclick="shareOnLinkedIn(event)">
                <i class="fa fa-linkedin"></i>

                                </a>
                                <a href="#" onclick="shareOnInstagram(event)">
                <i class="fa fa-instagram"></i>

                                </a>

<script>
  function shareOnFacebook(event) {
    event.preventDefault();
    var jobId = "{{ $job->id }}";
    var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent("https://xpertideaitsolutions.com/ems/humanResource/job-view/" + jobId);
    window.open(shareUrl, "_blank");
  }

  function shareOnTwitter(event) {
    event.preventDefault();
    var jobId = "{{ $job->id }}";
    var shareUrl = "https://twitter.com/intent/tweet?url=" + encodeURIComponent("https://xpertideaitsolutions.com/ems/humanResource/job-view/" + jobId);
    window.open(shareUrl, "_blank");
  }

  function shareOnLinkedIn(event) {
    event.preventDefault();
    var jobId = "{{ $job->id }}";
    var shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent("https://xpertideaitsolutions.com/ems/humanResource/job-view/" + jobId);
    window.open(shareUrl, "_blank");
  }

  function shareOnInstagram(event) {
    event.preventDefault();
    var jobId = "{{ $job->id }}";
    var shareUrl = "https://www.instagram.com/?url=" + encodeURIComponent("https://xpertideaitsolutions.com/ems/humanResource/job-view/" + jobId);
    window.open(shareUrl, "_blank");
  }
</script>


                          
                            <div class="other-openings-container" selectedJobId="48293" selectedDepartmentId="58764">
                            </div>
                            
                        </div>

            </div>
        </div>
    </div>
</div>
    
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> 

