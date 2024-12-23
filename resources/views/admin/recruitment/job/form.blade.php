@extends('admin.master')
@section('content')
@section('title')
@if(isset($editModeData))
	@lang('recruitement.edit_job_post')
@else
@lang('recruitement.create_new_job_post')
@endif
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
				<a href="{{route('jobPost.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('recruitement.view_job_post')  </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('jobPost.update', $editModeData->job_id), 'method' => 'PUT','files' => 'true','class' => 'form-horizontal','id'=>'jobPostForm')) }}
							@else
								{{ Form::open(array('route' => 'jobPost.store','enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'jobPostForm')) }}
							@endif
							
								<div class="form-body">
									<div class="row">
										<div class="col-md-offset-2 col-md-6">
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
										</div>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('recruitement.job_title')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('job_title',Input::old('job_title'), $attributes = array('class'=>'form-control required job_title','id'=>'job_title','placeholder'=>__('recruitement.job_title'))) !!}
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('recruitement.job_post')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('post',Input::old('post'), $attributes = array('class'=>'form-control required post','id'=>'post','placeholder'=>__('recruitement.job_post'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('recruitement.description')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::textarea('job_description',Input::old('job_description'), $attributes = array('class'=>'form-control textarea_editor required','rows'=>'15','id'=>'job_description','placeholder'=>__('recruitement.description'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('common.status')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{{ Form::select('status', array('1' => __('recruitement.published'), '0' => __('recruitement.unpublished')), Input::old('status'), array('class' => 'form-control status  required')) }}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('recruitement.job_publish_date')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('publish_date',(isset($editModeData)) ? dateConvertDBtoForm($editModeData->publish_date) : Input::old('publish_date'), $attributes = array('class'=>'form-control required dateField','id'=>'publish_date','placeholder'=>__('recruitement.job_publish_date'),'readonly'=>'readonly')) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('recruitement.application_end_date')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<div class="input-group">
														<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
														{!! Form::text('application_end_date',(isset($editModeData)) ? dateConvertDBtoForm($editModeData->application_end_date) : Input::old('application_end_date'), $attributes = array('class'=>'form-control dateField','id'=>'application_end_date','readonly'=>'readonly','placeholder'=>__('recruitement.application_end_date'))) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-offset-4 col-md-8">
													@if(isset($editModeData))
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-pencil"></i> @lang('common.update')</button>
													@else
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
													@endif
												</div>
											</div>
										</div>
									</div>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
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