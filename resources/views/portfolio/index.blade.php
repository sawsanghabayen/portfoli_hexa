<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="utf-8">
    <title>{{$infos[0]->full_name}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Template Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Template CSS Files -->
    <link type="text/css" media="all" href="{{asset('portfolio/css/bootstrap.min.css')}}" rel="stylesheet">
    <link type="text/css" media="all" href="{{asset('portfolio/css/jquery.animatedheadline.css')}}" rel="stylesheet">
    <link type="text/css" media="all" href="{{asset('portfolio/css/font-awesome.min.css')}}" rel="stylesheet">
    <link type="text/css" media="all" href="{{asset('portfolio/css/style.css')}}" rel="stylesheet">
    <link type="text/css" media="all" href="{{asset('portfolio/css/skins/goldrenrod.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Template JS Files -->
    <script src="{{asset('portfolio/js/modernizr.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('portfolio/css/styleswitcher.css')}}" />

</head>

<body class="light dark-header fullscreenbgimage">
    <div class="page">
        <!-- Header Starts -->
    <header id="header">
		<div class="nav-container">
			<div>
				<!-- Mobile Navigation Starts -->
				<ul id="nav" class="navigation">
					<li class="active">
						<div>
							<a id="link-home" href="#home" class="active">
								<i class="fa fa-home"></i><span>{{__('cp.home')}}</span>
							</a>
						</div>
					</li>
					<li>
						<div>
							<a id="link-about" href="#about">
								<i class="fa fa-user"></i><span>{{__('cp.about')}} {{__('cp.me')}}</span>
							</a>
						</div>
					</li>
                    <li>
						<div>
							<a id="link-contact" href="#contact">
								<i class="fa fa-envelope-open"></i><span>{{__('cp.get_in_touch')}} </span>
							</a>
						</div>
					</li>
					<li>
						<div>
							<a id="link-work" href="#work">
								<i class="fa fa-briefcase"></i><span>{{__('cp.my')}} {{__('cp.portfolio')}}</span>
							</a>
						</div>
					</li>
				
				</ul>
				<!-- Mobile Navigation Ends -->
			</div>
		</div>
		<!-- Stretchy Navigation Starts -->
		<div class="cd-stretchy-nav lighter">
			<a class="cd-nav-trigger" href="#0">
				<span aria-hidden="true"></span>
			</a>
		
			<ul class="stretchy-nav">
				<li class="active"><a class="home" href="#home"><span>{{__('cp.home')}}</span></a></li>
				<li><a href="#about"><span>{{__('cp.about')}}</span></a></li>
				<li><a href="#works"><span>{{__('cp.portfolio')}}</span></a></li>
				<li><a href="#contact"><span>{{__('cp.contact')}}</span></a></li>
                <li><a href="{{App::isLocale('en') ? LaravelLocalization::getLocalizedURL('ar') : LaravelLocalization::getNonLocalizedURL('en/en/portfolio-project')}}" class="page-scroll">{{App::isLocale('en') ? 'العربية' : 'الانجليزية'}}</a></li>

				{{-- <li><a href="#works"><span>{{__('cp.portfolio')}}</span></a></li> --}}
			</ul>
			<span aria-hidden="true" class="stretchy-nav-bg"></span>
			
		</div>

		<!-- Stretchy Navigation Ends -->
    </header>
    <!-- Header Ends -->
        <!-- Main Content Starts -->
        <main id="main">
            <!-- Back To Home Starts [ONLY MOBILE] -->
            <span class="back-mobile" id="back-mobile"><i class="fa fa-arrow-left"></i></span>
            <!-- Back To Home Ends [ONLY MOBILE] -->
            <!-- Home Section Starts -->
            <section id="home" class="active">

                <!-- Text Rotator Starts -->
                <div class="main-text-container">
                    <div class="main-text" id="selector">
                        <h3>{{__('cp.title_home')}} ! </h3>
                        <h1 class="ah-headline">
                            {{__('cp.im')}}
						  <span class="ah-words-wrapper">
							<b class="is-visible">{{$infos[0]->full_name}}</b>
							<b>{{$infos[0]->job}}</b>
						
						  </span>
					    </h1>
                        <p>{{$settings[0]->description_home}}</p>
                        <div class="call-to-actions-home">
                            <div class="text-left">
                                <a href="#about" class="btn link-portfolio-one"><span><i class="fa fa-user"></i>{{__('cp.more_about_me')}}</span></a>
                                <a href="#work" class="btn btn-secondary link-portfolio-two"><span><i class="fa fa-suitcase"></i>{{__('cp.portfolio')}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Text Rotator Ends -->
            </section>
            <!-- Home Section Ends -->
            <!-- About Section Starts -->
            <section id="about">
                <!-- Main Heading Starts -->
                <div class="container page-title text-center">
                    <h2 class="text-center">{{__('cp.about')}} <span>{{__('cp.me')}}</span></h2>
                    <span class="title-head-subtitle">{{$settings[0]->description_about}}</span>
                </div>
                <!-- Main Heading Ends -->
                <div class="container infos">
                    <div class="row personal-info">
                        <!-- Personal Infos Starts -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="image-container">
								<img class="img-fluid d-block" src="{{$infos[0]->image ?? ''}}"  alt="" />
							</div>
							{{-- <p  class="d-block d-md-none">I'm a Freelance UI/UX Designer and Developer based in London, England. I strives to build immersive and beautiful web applications through carefully crafted code and user-centric design.</p> --}}
						</div>
						<div class="row col-xl-6 col-lg-6 col-md-12">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
								<ul class="list-1">
									<li>
										<h6><span class="font-weight-600">{{__('cp.full_name')}}</span>{{$infos[0]->full_name}}</h6>
									</li>
									
									<li>
										<h6><span class="font-weight-600">{{__('cp.birthdate')}}</span>{{$infos[0]->birthdate}}</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.nationality')}}</span>{{$infos[0]->nationality}}</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.experience')}}</span>{{$infos[0]->experience}} years</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.address')}}</span>{{$infos[0]->location}}</h6>
									</li>
								</ul>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
								<ul class="list-2">
									<li>
										<h6><span class="font-weight-600">{{__('cp.freelance')}}</span>{{$infos[0]->active_status}}</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.languages')}}</span> 
                    

                            @foreach ($array as $one)
                                            
                            
                               {{($one) }} /
                            
                            
                            @endforeach
                             
                                        
                                        </h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.phone')}}</span>{{$infos[0]->mobile}}</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.email')}}</span>{{$infos[0]->email}}</h6>
									</li>
									<li>
										<h6><span class="font-weight-600">{{__('cp.link')}}</span>{{$infos[0]->link}}</h6>
									</li>
									
								</ul>
							</div>
						
						</div>
                        <!-- Personal Infos Ends -->
                    </div>
                </div>
                <!-- Download CV Starts -->
                <div class="container col-12 mx-auto text-center">
                    <hr class="about-section" />
                </div>
                <!-- Download CV Ends -->
                <!-- Resume Starts -->
                <div class="resume-container">
                    <div class="container">
                        <div class="row">
                            <!-- Experience Starts -->
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <h2 class="font-weight-600 uppercase title-section">{{__('cp.experience')}}</h2>
                                <div class="resume-items">
                                    <!-- Item Starts -->
                            @foreach ($experiences as $experience)

                                    <div class="item">
                                        <span class="bullet"></span>
                                        <div class="card">
                                            <div class="card-header">
                                                <span class="year"><i class="fa fa-calendar"></i><i class="fa fa-caret-right"></i>{{$experience->start_date}} - {{$experience->end_date}} </span>
                                                <span class="d-block font-weight-400 uppercase">
                                                    {{$experience->experience_name}} 
												<span class="separator"></span>
                                                <span class="font-weight-700">{{$experience->company_name}}</span>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <p>{{$experience->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
           
                                    <!-- Item Ends -->
                                </div>

                            </div>
                            <!-- Experience Ends -->
                            <!-- Education Starts -->
                            <div class="col-xl-6 col-lg-6 col-md-6 skills-container">
                                <h2 class="font-weight-600 uppercase title-section">{{__('cp.education')}}</h2>
                                <div class="resume-items">
                                    <!-- Item Starts -->
                            @foreach ($educations as $education )

                                    <div class="item">
                                        <span class="bullet"></span>
                                        <div class="card">
                                            <div class="card-header">
                                                <span class="year"><i class="fa fa-calendar"></i><i class="fa fa-caret-right"></i>{{$education->start_date}} - {{$education->end_date}} </span>
                                                <span class="d-block font-weight-400 uppercase">
                                                    {{$education->education_name}} 
												<span class="separator"></span>
                                                <span class="font-weight-700">{{$education->company_name}}</span>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <p>{{$education->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                    
                                    <!-- Item Ends -->
                                </div>
                            </div>
                            <!-- Education Ends -->
                        </div>
                        <!-- Skills Starts -->
                        <div class="row">
                            <!-- Skill Bar Starts -->
                            <div class="col-12">
                                <h2 class="font-weight-600 uppercase title-section skills-title">{{__('cp.skills')}}</h2>
                            </div>
							<!-- Skill Bar Starts -->

                            @foreach ($skills as $skill )
                                
                            <div class="col-12 col-sm-6 col-md-4">
                                <span class="skill-text">{{$skill->title}}</span>
                                <div class="chart-bar">
                                    <span class="item-progress" data-percent="{{$skill->degree}}" style="width: {{$skill->degree}}%;"></span>
                                    <span class="percent" style="right: calc(20% - 21px);">{{$skill->degree}}%<div class="arrow"></div></span>
                                </div>
                            </div>
                            @endforeach

                            <!-- Skill Bar Ends -->
                            <!-- Skill Bar Starts -->
                          
                            <!-- Skill Bar Ends -->
                        </div>
                        <!-- Skills Starts -->
                    </div>

                    <!-- Resume Ends -->
                </div>
            </section>
            <!-- About Section Ends -->

              <!-- Contact Section Starts -->
           
            <!-- Contact Section Ends -->
            <!-- Portfolio Section Starts -->
            <section id="work">
                <div class="portfolio-container">
                    <!-- Main Heading Starts -->
                    <div class="container page-title text-center">
                        <h2 class="text-center">{{__('cp.my')}} <span>{{__('cp.portfolio')}}</span></h2>
						<span class="title-head-subtitle">{{$settings[0]->description_portfolio}}</span>
                    </div>
                    <!-- Main Heading Ends -->
                    <div class="portfolio-section">
                        <div class="container cd-container">
                            <div>
                                <!-- Portfolio Items Starts -->
                                <ul class="row" id="portfolio-items">
                                    <!-- Portfolio Item Starts -->
                                    @foreach ($projects as $project )
                                    <li class="col-12 col-md-6 col-lg-4">
                                        <a href="#0" data-type="project-{{$project->id}}">
                                            <img src="{{$project->image ?? ''}}" alt="Project" class="img-fluid">
                                            <div>
                                            <span> 
                                                {{__('cp.image_formate')}}
                                                    
                                            </span>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                    

                                    <!-- Portfolio Item Ends -->
                          
                                    <!-- Portfolio Item Ends -->
                                </ul>
                                <!-- Portfolio Items Ends -->
                            </div>
                        </div>
                    </div>
					<!-- PORTFOLIO OVERLAY STARTS -->
					<div class="portfolio-overlay"></div>
					<!-- PORTFOLIO OVERLAY ENDS -->
                </div>
                <!-- Portfolio Project Content Starts -->
                @foreach ($projects as $project )
                <div class="project-info-container project-{{$project->id}}">
                    <!-- Main Content Starts -->

                    <div class="project-info-main-content">
                        <img src="{{$project->image ?? ''}} " alt="Project Image">
                    </div>
               
                    <!-- Main Content Ends -->
                    <!-- Project Details Starts -->
                    <div class="projects-info row">
                        <div class="col-12 col-sm-6 p-none">
                            <h3 class="font-weight-600 uppercase">
                                {{__('cp.image_formate')}}
                     
                            </h3>
                            <ul class="project-details">
                                <li><i class="fa fa-file-text-o"></i><span class="font-weight-400 project-label"> {{__('cp.project')}} </span>: <span class="font-weight-600 uppercase">{{$project->name}}</span>
                                </li>
                               
                                <li><i class="fa fa-hourglass-o"></i><span class="font-weight-400 project-label"> {{__('cp.duration')}}  </span>: <span class="font-weight-600 uppercase">{{$project->duration}} {{__('cp.months')}}</span>
                                </li>
                                <li><i class="fa fa-code"></i> <span class="font-weight-400 project-label"> {{__('cp.technologies')}} </span> : <span class="font-weight-600 uppercase">{{$project->technologies}}</span>
                                </li>
                                
                            </ul>
                            <a href="{{$project->url_website}}" class="btn"><span><i class="fa fa-external-link"></i>{{__('cp.preview')}} </span></a>
                        </div>
                        <div class="col-6 p-none text-right">
                            <a href="#" class="btn btn-secondary close-project"><span><i class="fa fa-close"></i>{{__('cp.close')}} </span></a>
                        </div>
                    </div>
                    {{-- <span class="back-mobile close-project"><i class="fa fa-arrow-left"></i></span> --}}
                    <!-- Project Details Ends -->
                </div>

                @endforeach

                    <!-- Project Details Ends -->
                </div>

                <!-- Portfolio Project Content Ends -->
                <span class="back-mobile close-project"><i class="fa fa-arrow-left"></i></span>
                <!-- Portfolio Project Content Ends -->
            </section>
            <!-- Portfolio Section Ends -->
        
           
            <section id="contact">
                <div class="contact-container">
                    <!-- Main Heading Starts -->
                    <div class="container page-title text-center">
                        <h2 class="text-center">{{__('cp.get')}} <span>{{__('cp.in_touch')}}</span></h2>
						<span class="title-head-subtitle">{{$settings[0]->description_contact}}</span>
                    </div>
                    <!-- Main Heading Ends -->
                    <div class="container">
                        <div class="row contact">
                            <!-- Contact Infos Starts -->
                            <div class="col-12 col-md-4 col-xl-4 leftside">
                                <ul class="custom-list">
                                    <li>
                                        <h6 class="font-weight-600"> <span class="contact-title">{{__('cp.phone')}}</span><i class="fa fa-whatsapp"></i><span class="contact-content">{{$infos[0]->mobile}}</span></h6>
                                    </li>
                                    <li>
                                        <h6 class="font-weight-600"> <span class="contact-title">{{__('cp.email')}}</span><i class="fa fa-envelope-o fs-14"></i><span class="contact-content">{{$infos[0]->email}}</span></h6>

                                    </li>
                                    <li>
                                        <h6 class="font-weight-600"><span class="contact-title">{{__('cp.instagram')}}</span><i class="fa fa-instagram"></i><span class="contact-content">{{$infos[0]->facebook_url}}</span></h6>

                                    </li>
                                    <li>
                                        <h6 class="font-weight-600"><span class="contact-title">{{__('cp.link')}}</span><i class="fa fa-link"></i><span class="contact-content">{{$infos[0]->link}}</span></h6>

                                    </li>
                                   
                                </ul>

                                <!-- Social Media Profiles Starts -->

                                <div class="social">
                                    <h6 class="font-weight-600 uppercase">{{__('cp.social_profile')}}</h6>
                                    <ul class="list-inline social social-intro text-center p-none">
                                        <li class="facebook"><a title="Facebook" href="{{$infos[0]->facebook_url}}"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="twitter"><a title="Twitter" href="{{$infos[0]->twitter_url}}"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="youtube"><a title="Youtube" href="{{$infos[0]->youtube_url}}"><i class="fa fa-youtube"></i></a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <!-- Social Media Profiles Ends -->
                            </div>
                            <!-- Contact Infos Ends -->
                            <!-- Contact Form Starts -->
                            <div class="col-12 col-md-8 col-xl-8 rightside">
                                <p>
                                    {{$settings[0]->description_contact}}
                                </p>
                                <form id="create-form" class="contactform" >
                                    <div class="row">
                                        <!-- Name Field Starts -->
                                        <div class="form-group col-xl-6"> <i class="fa fa-user prefix"></i>
                                            <input id="name"  type="text" class="form-control" placeholder="{{__('cp.your_name')}}" required>
                                        </div>
                                        <!-- Name Field Ends -->
                                        <!-- Email Field Starts -->
                                        <div class="form-group col-xl-6"> <i class="fa fa-envelope prefix"></i>
                                            <input id="email" type="email" class="form-control" placeholder="{{__('cp.your_email')}}"  required>
                                        </div>
                                        <!-- Email Field Ends -->
                                        <!-- Comment Textarea Starts -->
                                        <div class="form-group col-xl-12"> <i class="fa fa-messages prefix"></i>
                                            <textarea id="message" class="form-control" placeholder="{{__('cp.your_message')}}"  required></textarea>
                                        </div>
                                        <!-- Comment Textarea Ends -->
                                    </div>
                                    <!-- Submit Form Button Starts -->
                                    <div class="submit-form">
                                            {{-- <button class="btn button-animated" type="submit" name="send"><span><i class="fa fa-send"></i> Send Message</span></button> --}}
                                        {{-- <input  type="button" name="send"><span><i class="fa fa-send" onclick="performStore()"></i> Send Message</span></button> --}}
                                        <button  onclick="performStore()" class="btn button-animated" name="send"><span><i class="fa fa-send" ></i> {{__('cp.send_message')}} </span></button>
                                    </div>
                                    <!-- Submit Form Button Ends -->
                                    {{-- <div class="form-message"> <span class="output_message text-center font-weight-600 uppercase"></span>
                                    </div> --}}
                                </form>
                            </div>
                            <!-- Contact Form Ends -->

                        </div>
                    </div>
                </div>
            </section>
            <!-- Blog Section Ends -->
        </main>
    </div>
    <!-- Main Content Ends -->
    <!-- Preloader Starts -->
    <div class="preloader">
        <div class="preloader-container">
            <h1>{{$infos[0]->full_name}}</h1>
            <div id="progress-line-container">
                <div class="progress-line"></div>
            </div>
            {{-- <h1>{{$infos[0]->l_name}}</h1> --}}
        </div>
    </div>
    <!-- Preloader Ends -->

    <!-- Template JS Files -->
    <script src="{{asset('portfolio/js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('portfolio/js/jquery.animatedheadline.js')}}"></script>
    <script src="{{asset('portfolio/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('portfolio/js/transition.js')}}"></script>
    <!-- Live Style Switcher JS File - only demo -->
    <script src="{{asset('portfolio/js/styleswitcher.js')}}"></script>
    <!-- Main JS Initialization File -->
    <script src="{{asset('portfolio/js/custom.js')}}"></script>
<script src="{{asset('controlPanel/assets/js/pages/features/miscellaneous/toastr.js')}}"></script>
{{-- <script src="{{asset('controlPanel/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script> --}}
<script src="{{asset('js/axios.js')}}"></script>

<script src="{{asset('js/crud.js?n=1')}}"></script>
<script>
    
    function performStore() {
    //    alert(response.data.message);
      
      //application/x-www-form-urlencoded
      axios.post('/portfolio-project/message', {
          name: document.getElementById('name').value,
          email: document.getElementById('email').value,
          message: document.getElementById('message').value,

      })
      .then(function (response) {
          console.log(response);

        //   dd(response.data);
        alert(response.data.message);
        document.getElementById('create-form').reset();
        //   toastr.success(response.data.message);
      })
      .catch(function (error) {
          console.log(error.response);
        //   toastr.error(error.response.data.message);
      });

  
  }
</script>
</body>

</html>