@extends('admin.master')
@section('content')

@section('title')
@if(isset($editModeData))
	@lang('warning.edit_warning')
@else
 @lang('warning.add_warning')
@endif

@endsection


	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				  
				</ol>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{route('warning.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('warning.view_warning')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('warning.update', $editModeData->warning_id), 'method' => 'PUT','files' => 'true','class' => 'form-horizontal')) }}
							@else
								{{ Form::open(array('route' => 'warning.store','enctype'=>'multipart/form-data','class'=>'form-horizontal')) }}
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
											<label class="control-label col-md-4">@lang('warning.employee_name')<span class="validateRq">*</span></label>
											<div class="col-md-8">
												{{ Form::select('warning_to',$employeeList, Input::old('warning_to'), array('class' => 'form-control warning_to select2 required')) }}
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label col-md-4">@lang('warning.warning_type')<span class="validateRq">*</span></label>
											<div class="col-md-8">
												{!! Form::text('warning_type',Input::old('warning_type'), $attributes = array('class'=>'form-control required warning_type','id'=>'warning_type','placeholder'=>__('warning.warning_type'))) !!}
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label col-md-4">@lang('warning.subject')<span class="validateRq">*</span></label>
											<div class="col-md-8">
												{!! Form::text('subject',Input::old('subject'), $attributes = array('class'=>'form-control required subject','id'=>'subject','placeholder'=>__('warning.subject'))) !!}
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label col-md-4">@lang('warning.warning_by')<span class="validateRq">*</span></label>
											<div class="col-md-8">
												{{ Form::select('warning_by',$employeeList, session('logged_session_data.employee_id'), array('class' => 'form-control warning_by select2 required')) }}
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label col-md-4">@lang('warning.warning_date')<span class="validateRq">*</span></label>
											<div class="col-md-8">
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												{!! Form::text('warning_date',isset($editModeData) ? dateConvertDBtoForm($editModeData->warning_date) : Input::old('warning_date'), $attributes = array('class'=>'form-control required dateField','id'=>'warning_date','placeholder'=>__('warning.warning_date'),'readonly'=>'readonly')) !!}
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label col-md-4">@lang('warning.description')</label>
											<div class="col-md-8">
												{!! Form::textarea('description',Input::old('description'), $attributes = array('class'=>'form-control description','id'=>'warning_date','placeholder'=>__('warning.description'))) !!}
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
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-pencil"></i> @lang('common.udpate')</button>
													@else
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
													@endif
												</div>
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
            $('.description').wysihtml5();

            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                new CBPFWTabs(el);
            });
        })();
	</script>
@endsection

