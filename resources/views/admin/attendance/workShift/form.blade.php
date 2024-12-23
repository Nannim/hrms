@extends('admin.master')
@section('content')

@section('title')

@if(isset($editModeData))
@lang('work_shift.edit_work_shift')
	
@else
  @lang('work_shift.add_work_shift')
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
				<a href="{{route('workShift.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('work_shift.view_work_shift')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('workShift.update', $editModeData->work_shift_id), 'method' => 'PUT','files' => 'true','id' => 'workShiftForm','class' => 'form-horizontal')) }}
							@else
								{{ Form::open(array('route' => 'workShift.store','enctype'=>'multipart/form-data','id'=>'workShiftForm','class' => 'form-horizontal')) }}
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
												<label class="control-label col-md-4">@lang('work_shift.work_shift_name')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('shift_name',Input::old('shift_name'), $attributes = array('class'=>'form-control required shift_name','id'=>'shift_name','placeholder'=>__('work_shift.work_shift_name'))) !!}
												</div>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('work_shift.start_time')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
														<div class="bootstrap-timepicker">
															{!! Form::text('start_time',(isset($editModeData)) ? date("h:i a", strtotime($editModeData->start_time)) :  Input::old('start_time'), $attributes = array('class'=>'form-control timePicker','id'=>'timepicker','placeholder'=>__('work_shift.start_time'))) !!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('work_shift.end_time')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
														<div class="bootstrap-timepicker">
															{!! Form::text('end_time',(isset($editModeData)) ? date("h:i a", strtotime($editModeData->end_time)) :  Input::old('start_time'), $attributes = array('class'=>'form-control timePicker','id'=>'timepicker','placeholder'=>__('work_shift.end_time'))) !!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('work_shift.late_count_time')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
														<div class="bootstrap-timepicker">
															{!! Form::text('late_count_time',(isset($editModeData)) ? date("h:i a", strtotime($editModeData->late_count_time)) :  Input::old('start_time'), $attributes = array('class'=>'form-control timePicker','id'=>'late_count_time','placeholder'=>__('work_shift.late_count_time'))) !!}
														</div>
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


