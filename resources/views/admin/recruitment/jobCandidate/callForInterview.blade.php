@extends('admin.master')
@section('content')
@section('title','Job Interview')
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
		font-size: 16px;
		padding: 18px 16px;
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
				@if($results)
					<p class="box-title post" >Job Name :
						{{$results->job->job_title}}
					</p>
				@endif
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
			@if($results)
				{{ Form::open( array('route' => array('applicant.jobInterviewStore', $results->job_applicant_id), 'files' => 'true','id' => 'workShiftForm')) }}

				<div class="col-md-offset-2 col-md-7 ">
					@if($errors->any())
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							@foreach($errors->all() as $error)
								<strong>{!! $error !!}</strong><br>
							@endforeach
						</div>
					@endif
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
					<div class="panel panel-default">
						<div class="panel-heading">{{$results->applicant_name}}</div>
							<div class="col-md-4" style="margin-top: 16px;">
								<label for="exampleInput">Interview Date<span class="validateRq">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									{!! Form::text('interview_date',Input::old('interview_date'), $attributes = array('class'=>'form-control required dateField','id'=>'interview_date','placeholder'=>'Enter interview date','readonly')) !!}
								</div>
							</div>
							<div class="col-md-4" style="margin-top: 16px;">
								<label for="exampleInput">Interview Date<span class="validateRq">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<div class="bootstrap-timepicker">
										{!! Form::text('interview_time',Input::old('interview_time'), $attributes = array('class'=>'form-control required timePicker','id'=>'timePicker','placeholder'=>'Enter time','readonly')) !!}
									</div>
								</div>
							</div>
							<div class="col-md-4"  style="margin-top: 16px;">
								<div class="form-group">
									<label for="exampleInput">Interview Type<span class="validateRq">*</span></label>
									{{ Form::select('interview_type', array('Email' => 'Email'), Input::old('interview_type'), array('class' => 'form-control interview_type select2 required')) }}
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInput">Comment<span class="validateRq">*</span></label>
									{!! Form::textarea('comment',Input::old('comment'), $attributes = array('class'=>'form-control textarea_editor required','rows'=>'8','id'=>'comment','placeholder'=>'Enter comment...')) !!}

								</div>
							</div>
							<div class="panel-footer">
								<input type="submit" class="btn btn-info" style="width: 200px" value="Job Interview">
							</div>
						</div>
					</div>
				</div>
		{{ Form::close() }}
			@else
				<div class="col-md-offset-2 col-md-7 ">
					<div style="background: #fff;padding: 2px 11px;">
						<h4>Job application not  found....</h4></div>
				</div>
			@endif
		</div>
	</div>
@endsection
@section('page_scripts')
	<link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/html5-editor/bootstrap-wysihtml5.css')!!}" />
	<script src="{!! asset('admin_assets/js/cbpFWTabs.js')!!}"></script>
	<script src="{!! asset('admin_assets/plugins/bower_components/html5-editor/wysihtml5-0.3.0.js')!!}"></script>
	<script src="{!! asset('admin_assets/plugins/bower_components/html5-editor/bootstrap-wysihtml5.js')!!}"></script>
	<script type="text/javascript">
        (function() {
            $('.textarea_editor').wysihtml5();
            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                new CBPFWTabs(el);
            });
        })();

	</script>
@endsection