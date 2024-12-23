@php
$front_setting = getFrontData();
@endphp
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Home Page')</title>
    @yield('meta')

    <meta name="author" content="shakhawat" />

    <link rel="shortcut icon" href="{{ url('admin_assets/img/logo.png') }}">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ url('front-assets/css/bootstrap.min.css') }}" type="text/css">

    <!--Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ url('front-assets/css/materialdesignicons.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ url('front-assets/css/fontawesome.css') }}" />

    <!-- selectize css -->
    <link rel="stylesheet" type="text/css" href="{{ url('front-assets/css/selectize.css') }}" />

    <!--Slider-->
    <link rel="stylesheet" href="{{ url('front-assets/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ url('front-assets/css/owl.theme.css') }}" />
    <link rel="stylesheet" href="{{ url('front-assets/css/owl.transitions.css') }}" />

    <!-- Custom  Css -->
    <link rel="stylesheet" type="text/css" href="{{ url('front-assets/css/style.css') }}" />

</head>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <!-- Navigation Bar-->
    <header id="topnav" class="defaultscroll scroll-active">

        <!-- Menu Start -->
        <div class="container">
            <!-- Logo container-->
            <div>
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ url('uploads/front/'.$front_setting->logo) }}" alt="" class="logo-light"  style="height: 90px;" />
                    <img src="{{ url('uploads/front/'.$front_setting->logo) }}" alt="" class="logo-dark"  style="height: 70px;"/>
                </a>
            </div>                 
            <div class="buy-button">
                @if(Auth::check())
                <a href="{{ url('dashboard') }}" class="btn btn-primary"><i class="mdi mdi-dashboard"></i> Dashboard</a>
                @endif
            </div><!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
    
            <div id="navigation">
                <!-- Navigation Menu-->   
                <ul class="navigation-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>

                    @if(Route::getCurrentRoute()->uri() == '/')
                    @if($front_setting->show_service == 1)
                    <li><a href="#services">Service</a></li>
                    @endif
                    @if($front_setting->show_job == 1)
                    <li><a href="#jobs">Career</a></li>
                    @endif
                    @if($front_setting->show_about == 1)
                    <li><a href="#about">About</a></li>
                    @endif
                    @if($front_setting->show_contact == 1)
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                    @endif
                    @else
                    @if($front_setting->show_service == 1)
                    <li><a href="{{ url('/') }}#services">Service</a></li>
                    @endif
                    @if($front_setting->show_job == 1)
                    <li><a href="{{ url('/') }}#jobs">Career</a></li>
                    @endif
                    @if($front_setting->show_about == 1)
                    <li><a href="{{ url('/') }}#about">About</a></li>
                    @endif
                    @if($front_setting->show_contact == 1)
                    <li>
                        <a href="{{ url('/') }}#contact">Contact</a>
                    </li>
                    @endif
                    @endif
                </ul><!--end navigation menu-->
            </div><!--end navigation-->
        </div><!--end container-->
        <!--end end-->
    </header><!--end header-->
    <!-- Navbar End -->
   


     @yield('content');



    <!-- footer start -->
    <!-- <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                    <a href="javascript:void(0)"><img src="images/logo-light.png" height="20" alt=""></a>
                    <p class="mt-4">At vero eos et accusamus et iusto odio dignissim os ducimus qui blanditiis praesentium</p>
                    <ul class="social-icon social list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-google"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <p class="text-white mb-4 footer-list-title">Company</p>
                    <ul class="list-unstyled footer-list">
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> About Us</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Media & Press</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Career</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Blog</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Pricing</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Marketing</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> CEOs </a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Agencies</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Our Apps</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <p class="text-white mb-4 footer-list-title">Resources</p>
                    <ul class="list-unstyled footer-list">
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Support</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Privacy Policy</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Terms</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Accounting </a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Billing</a></li>
                        <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> F.A.Q.</a></li>
                    </ul>
                </div>
            
                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <p class="text-white mb-4 footer-list-title f-17">Business Hours</p>
                    <ul class="list-unstyled text-foot mt-4 mb-0">
                        <li>Monday - Friday : 9:00 to 17:00</li>
                        <li class="mt-2">Saturday : 10:00 to 15:00</li>
                        <li class="mt-2">Sunday : Day Off (Holiday)</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer> -->
    <!-- footer end -->
    <!-- <hr> -->
    <footer class="footer footer-bar">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="">
                        <p class="mb-0">{!! $front_setting->footer_text !!}</p>
                    </div>
                </div>
            </div>
        </div><!--end container-->
    </footer><!--end footer-->
    <!-- Footer End -->

    <!-- Back to top -->
    <a href="#" class="back-to-top rounded text-center" id="back-to-top"> 
        <i class="mdi mdi-chevron-up d-block"> </i> 
    </a>
    <!-- Back to top -->

    <!-- javascript -->
    <script src="{{ asset('front-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/plugins.js') }}"></script>

    <!-- selectize js -->
    <script src="{{ asset('front-assets/js/jquery.nice-select.min.js') }}j"></script>
    <script src="{{ asset('front-assets/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('front-assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/counter.int.js') }}"></script>

    <script src="{{ asset('front-assets/js/app.js') }}"></script>
    <script src="{{ asset('front-assets/js/home.js') }}"></script>
     
    @stack('javascript')
</body>
</html>