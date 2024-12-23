@php
$front_setting = getFrontData();
@endphp
@extends('front.master')

@section('title')
{{ $front_setting->company_title }}
@endsection

@section('meta')

<meta name="og:title" content="{{ $front_setting->company_title }}" />
<meta name="og:image" content="{{ url('uploads/front/'.$front_setting->logo) }}" />
<meta name="og:url" content="{{ url('/') }}" />
<meta name="og:description" content="{{ $front_setting->about_us_description }}" />
<meta name="description" content="{{ $front_setting->about_us_description }}" />

@endsection

@section('content')
    <!-- Start Home -->
    <section  class="bg-home" style="background: url('{{ url('front-assets/images/cover.png') }}') center center;">
        <div class="bg-overlay"></div>
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="title-heading text-center text-white">

                                <h1 class="heading font-weight-bold mb-4"> {!! $front_setting->home_page_big_title !!} </h1>
                                <h6 class="small-title text-uppercase text-light mb-3">
                                {!! $front_setting->short_description !!}
                               </h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- end home -->
@if($front_setting->show_service == 1)
    <!-- popular category start -->
    <section class="section" id="services">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="title title-line pb-5">{{ $front_setting->service_title }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">

            @foreach($services as $value)
                <div class="col-lg-3 col-md-6 mt-4 pt-2">
                    <a href="javascript:void(0)">
                        <div class="popu-category-box bg-light rounded text-center p-4">
                            <div class="popu-category-icon mb-3">
                            <img src="{{ url('uploads/services/'.$value->service_icon) }}">
                            </div>
                            <div class="popu-category-content">
                                <h5 class="mb-2 text-dark title">{{ $value->service_name }}</h5>
                                <!-- <p class="text-success mb-0 rounded">780 Jobs</p> -->
                            </div>
                        </div>
                    </a>
                </div>
             @endforeach    
            </div>
         
<!-- 
            <div class="row justify-content-center">
                <div class="col-12 text-center mt-4 pt-2">
                    <a href="javascript:void(0)" class="btn btn-primary-outline">Browse All Categories <i class="mdi mdi-chevron-right"></i></a>
                </div>
            </div> -->
        </div>
    </section>
    <!-- popular category end -->

    @endif


    @if($front_setting->show_job == 1)
    <!-- all jobs start -->
    <section class="section bg-light" id="jobs">
        <div class="container">
            <div class="row justify-content-center career">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="title title-line pb-5">{{ $front_setting->job_title }}</h4>
                    </div>
                </div>
            </div>
             <div  class="data">
                 @include('front.job_pagination')
             </div>
        </div>
        <!-- end containar -->
    </section>
    <!-- all jobs end -->
    @endif


    @if($front_setting->show_counter == 1)
    <!-- counter start -->
    <section id="counters" class="section bg-counter position-relative" style="background: url('{{ url('front-assets/images/bg-counters.jpg') }}') center center;">
        <div class="bg-overlay bg-overlay-gradient"></div>
        <div class="container">
            <div class="row text-center" id="counter">
                <div class="col-md-3 col-6">
                    <div class="home-counter pt-4 pb-4">
                        <div class="float-left counter-icon mr-3">
                        
                        </div>
                        <div class="counter-content overflow-hidden">
                            <h1 class="counter-value text-white mb-1" data-count="120">{{ $front_setting->counter_1_value }}</h1>
                            <p class="counter-name text-white text-uppercase mb-0">{{ $front_setting->counter_1_title }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="home-counter pt-4 pb-4">
                        <div class="float-left counter-icon mr-3">
                           
                        </div>
                        <div class="counter-content overflow-hidden">
                            <h1 class="counter-value text-white mb-1" data-count="480">{{ $front_setting->counter_2_value }}</h1>
                            <p class="counter-name text-white text-uppercase mb-0">{{ $front_setting->counter_2_title }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="home-counter pt-4 pb-4">
                        <div class="float-left counter-icon mr-3">
                            
                        </div>
                        <div class="counter-content overflow-hidden">
                            <h1 class="counter-value text-white mb-1" data-count="120">{{ $front_setting->counter_3_value }}</h1>
                            <p class="counter-name text-white text-uppercase mb-0">{{ $front_setting->counter_3_title }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="home-counter pt-4 pb-4">
                        <div class="float-left counter-icon mr-3">

                        </div>
                        <div class="counter-content overflow-hidden">
                            <h1 class="counter-value text-white mb-1" data-count="200">{{ $front_setting->counter_4_value }}</h1>
                            <p class="counter-name text-white text-uppercase mb-0">{{ $front_setting->counter_4_title }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- counter end -->

    @endif
  
    @if($front_setting->show_about == 1)
    <!-- ABOUT US START -->
    <section class="section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-4">
                    <img src="{{ url('uploads/front/'.$front_setting->about_us_image) }}" class="img-fluid rounded shadow" alt="">
                </div>

                <div class="col-lg-7 col-md-8">
                    <div class="about-desc ml-lg-4">
                        {{ $front_setting->about_us_description }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ABOUT US END -->

    @endif

    @if($front_setting->show_contact)
        <!-- MAP START -->
        <section class="section pt-0 bg-light" id="contact">
        <div class="container mt-100 mt-60">
            <div class="row align-items-center text-center" style="padding-top: 50px;">
                <div class="col-lg-3">
                    <div class="contact-item mt-40">
                        <div >
                            <div class="contact-icon d-inline-block border rounded-pill shadow text-primary mt-1 mr-4">
                                <i class="mdi mdi-earth"></i>
                            </div>
                        </div>
                        <div class="contact-details">
                            <p class="mb-0 mt-2 text-muted">{{ $front_setting->contact_website }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="contact-item mt-40">
                        <div >
                            <div class="contact-icon d-inline-block border rounded-pill shadow text-primary mt-1 mr-4">
                                <i class="mdi mdi-cellphone-iphone"></i>
                            </div>
                        </div>
                        <div class="contact-details">
   
                            <p class="mb-0 mt-2 text-muted">{{ $front_setting->contact_phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="contact-item mt-40">
                        <div >
                            <div class="contact-icon d-inline-block border rounded-pill shadow text-primary mt-1 mr-4">
                                <i class="mdi mdi-email"></i>
                            </div>
                        </div>
                        <div class="contact-details">
                            <p class="mb-0 mt-2 text-muted">{{ $front_setting->contact_email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="contact-item mt-40">
                        <div >
                            <div class="contact-icon d-inline-block border rounded-pill shadow text-primary mt-1 mr-4">
                            <i class="mdi mdi-map-marker"></i>
                            </div>
                        </div>
                        <div class="contact-details">
                            <p class="mb-0 mt-2 text-muted">{{ $front_setting->contact_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTACT END -->
    @endif

    @endsection

@push('javascript')
<script>
        $(function() {
            $('.data').on('click', '.pagination a', function (e) {
                getData($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });


        });

        function getData(page) {

            $.ajax({
                url : '?page=' + page,
                datatype: "html",
            }).done(function (data) {
                $('.data').html(data);
                $('html,body').animate({
        scrollTop: $(".career").offset().top},
        'slow');
            }).fail(function () {
                alert('No response from server');
            });
        }
    </script>
    
    <script>
       
       $(document).ready(function(){
         // Add smooth scrolling to all links
         $(".navigation-menu li a").on('click', function(event) {
       
           // Make sure this.hash has a value before overriding default behavior
           if (this.hash !== "") {
             // Prevent default anchor click behavior
             event.preventDefault();
       
             // Store hash
             var hash = this.hash;
       
             // Using jQuery's animate() method to add smooth page scroll
             // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
             $('html, body').animate({
               scrollTop: $(hash).offset().top
             }, 800, function(){
          
               // Add hash (#) to URL when done scrolling (default click behavior)
               window.location.hash = hash;
             });
           } // End if
         });
       });
       
           </script>
@endpush
