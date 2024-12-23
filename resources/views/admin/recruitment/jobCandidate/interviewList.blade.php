@extends('admin.master')
@section('content')
@section('title','Job Interview List')
<style>
	.downloadResume{
		font-size: 15px;
		color: #777;
		font-weight: 500;
	}
	.post{
		font-weight: 500;
		font-size: 16px;
	}
	.applicationDate{
		font-size: 13px;
		color: #98a6ad;
	}
	.coverLater{
		margin-top: 5px;
	}
	.panel .panel-heading {
		border-radius: 0;
		font-weight: 500;
		font-size: 14px;
		padding: 10px 25px;
	}
</style>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-7 col-md-7 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-md-offset-2 col-md-7">
				<p class="box-title post" >Job Name : {{$job->job_title}}</p>
				<br>
				@if(session()->has('success'))
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
					</div>
				@endif
				@if(session()->has('error'))
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
					</div>
				@endif
			</div>
			@if(count($results) > 0)
				@foreach($results as $value)
					<div class="col-md-offset-2 col-md-7 ">
						<div class="panel panel-default">
							<div class="panel-heading">{{$value->applicant_name}} <span class="applicationDate">&nbsp; Called  for interview </span>{{$job->post}} <span class="applicationDate">&nbsp;Position </span></div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">

									<p class="coverLater">@if(isset($value->interviewInfo->comment)) {!! $value->interviewInfo->comment !!} @endif</p>
									<a class="downloadResume" href="{!! asset('uploads/applicantResume/'.$value->attached_resume) !!}" download=""><i class="fa fa-download"></i> Download Resume</a>
								</div>
								<div class="panel-footer">
									<p>
										<b>Date :</b>@if(isset($value->interviewInfo->interview_date)) {{date(" d M Y ", strtotime($value->interviewInfo->interview_date))}}@endif&nbsp;
										<b>Time :</b>@if(isset($value->interviewInfo->interview_time))
											{{date("g:i A", strtotime($value->interviewInfo->interview_time))}}
										@endif
									</p>
								</div>
							</div>
						</div>
					</div>
				@endforeach
					<div class="col-md-offset-2 col-md-7 text-center">
						{{$results->links()}}
					</div>
			@else
				<div class="col-md-offset-2 col-md-7 ">
					<div style="background: #fff;padding: 2px 11px;">
						<h4>You have no job interview candidate....</h4> </div>
				</div>
			@endif
		</div>
	</div>
@endsection
