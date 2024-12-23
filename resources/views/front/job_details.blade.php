@extends('front.master')

@section('title')
{{ $job->job_title }}
@endsection

@php
$front_setting = getFrontData();
@endphp

@section('meta')

<meta name="og:title" content="{{ $job->job_title }}" />
<meta name="og:image" content="{{ url('uploads/front/'.$front_setting->logo) }}" />
<meta name="og:url" content="{{ route('job.details',['id' => $job->job_id,'slug' => str_replace(' ','-',strtolower($job->job_title))]) }}" />
<meta name="og:description" content="{{ $job->job_post }}" />
<meta name="description" content="{{ $job->job_post }}" />

@endsection
@section('content')
   <!-- Start home -->
   <section class="bg-half page-next-level" style="background: url('{{ url('front-assets/images/cover.png') }}') center center;">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center text-white">
                        <h4 class="text-uppercase title mb-4">Job Details</h4>
                        <ul class="page-next d-inline-block mb-0">
                            <li><a href="{{ url('/') }}" class="text-uppercase font-weight-bold">Home</a></li>
                            <li><a href="#" class="text-uppercase font-weight-bold">Job</a></li>
                            <li>
                                <span class="text-uppercase text-white font-weight-bold">{{  $job->job_title  }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end home -->

    <!-- JOB SINGLE START -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="mr-auto mx-auto col-lg-10 col-md-10">

                    @if($errors->any())
                    <!-- <div class="job-detail text-center job-single border rounded p-4 mb-20"> -->
								<div class="alert alert-danger alert-dismissible mb-20" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
									@foreach($errors->all() as $error)
										<strong>{!! $error !!}</strong><br>
									@endforeach
                                </div>
                                <!-- </div> -->
                    @endif

                    @if(session()->has('success'))
								<div class="alert alert-success alert-dismissable  mb-20">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable  mb-20">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
                    <div class="job-detail text-center job-single border rounded p-4">
                        <div class="job-single-img mb-2">
                            <img src="images/featured-job/img-1.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                        <h4 class=""><a href="#" class="text-dark">{{ $job->post }}</a></h4>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item mr-3">
                                <p class="text-muted mb-2"><i class="fa fa-calendar  mr-1"></i>Published at : {{date("d M Y", strtotime($job->created_at))}}</p>
                            </li>

                            <li class="list-inline-item">
                                <p class="text-muted mb-2"><i class="fa fa-calendar-times mr-1"></i>Deadline : {{date("d M Y", strtotime($job->application_end_date))}}</p>
                            </li>
                        </ul>
                       
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="text-dark mt-4">Job Description :</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="job-detail border rounded mt-2 p-4">
                                <div class="job-detail-desc">
                                   {!! $job->job_description !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="text-dark mt-4">Apply for this Job:</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="job-detail border rounded mt-2 p-4">
                            <form action="{{ route('job.application') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="job_id"  value="{{ $job->job_id }}">
                               {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group app-label">
                                        <label class="text-muted">Name</label>
                                        <input name="name" value="{{ old('name') }}" type="text" class="form-control resume" placeholder="Applicant Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group app-label">
                                        <label class="text-muted">Email</label>
                                        <input name="email" value="{{ old('email') }}" type="email" class="form-control resume" placeholder="Applicant Email">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group app-label">
                                        <label class="text-muted">Phone No</label>
                                        <input name="phone" value="{{ old('phone') }}" type="text" class="form-control resume" placeholder="Phone No">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group app-label">
                                        <label class="text-muted">Attach Resume</label>
                                        <input name="resume" type="file" class="form-control resume" placeholder="Resume">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group app-label">
                                        <label>Cover Letter :</label>
                                        <textarea name="cover_letter" id="addition-information" rows="4" class="form-control resume" placeholder="Write Something About You">{{ old('name') }}</textarea>
                                    </div>

                                    <input type="submit" id="submit"  class="submitBnt btn btn-primary" value="Apply">
                                </div>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- JOB SINGLE END -->
@endsection
