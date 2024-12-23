@extends('admin.master')
@section('content')

@section('title')

@if(isset($editModeData))
    @lang('promotion.edit_employee_promotion')
@else
	@lang('promotion.add_employee_promotion')
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
				<a href="{{route('promotion.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('promotion.view_employee_promotion')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">

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
									<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif

							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('promotion.update', $editModeData->promotion_id), 'method' => 'PUT','files' => 'true','id' => 'promotionForm')) }}
							@else
								{{ Form::open(array('route' => 'promotion.store','enctype'=>'multipart/form-data','id' => 'promotionForm')) }}
							@endif

							<div class="form-body">

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('common.employee_name')<span class="validateRq">*</span></label>
											{{ Form::select('employee_id', $employeeList, Input::old('employee_id'), array('class' => 'form-control employee_id required select2')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.current_department')<span class="validateRq">*</span></label>
											{{ Form::select('current_department', $departmentList, Input::old('current_department'), array('class' => 'form-control current_department required','id'=>'current_department','style'=>'pointer-events: none')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.current_designation')<span class="validateRq">*</span></label>
											{{ Form::select('current_designation', $designationList, Input::old('current_designation'), array('class' => 'form-control current_designation required','id'=>'current_designation','style'=>'pointer-events: none')) }}
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.current_paygrade')<span class="validateRq">*</span></label>
											{{ Form::select('current_pay_grade', $payGradeList, Input::old('current_pay_grade'), array('class' => 'form-control current_pay_grade required ','id'=>'current_pay_grade','style'=>'pointer-events: none')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.current_salary')<span class="validateRq">*</span></label>
											{!! Form::text('current_salary',Input::old('current_salary'), $attributes = array('class'=>'form-control required current_salary','id'=>'current_salary','readonly'=>'readonly','placeholder'=>__('promotion.current_salary'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.promoted_pay_grade')<span class="validateRq">*</span></label>
											{{ Form::select('promoted_pay_grade', $payGradeList, Input::old('promoted_pay_grade'), array('class' => 'form-control promoted_pay_grade required select2','id'=>'promoted_pay_grade')) }}
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.new_salary')<span class="validateRq">*</span></label>
											{!! Form::text('new_salary',Input::old('new_salary'), $attributes = array('class'=>'form-control required new_salary','id'=>'new_salary','readonly'=>'readonly','placeholder'=>__('promotion.new_salary'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.promoted_department')<span class="validateRq">*</span></label>
											{{ Form::select('promoted_department', $departmentList, Input::old('promoted_department'), array('class' => 'form-control promoted_department required select2')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('promotion.promoted_designation')<span class="validateRq">*</span></label>
											{{ Form::select('promoted_designation', $designationList, Input::old('promoted_designation'), array('class' => 'form-control promoted_designation required select2')) }}
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<label for="exampleInput">@lang('promotion.promotion_date')<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											{!! Form::text('promotion_date',isset($editModeData) ? dateConvertDBtoForm($editModeData->promotion_date) : Input::old('promotion_date'), $attributes = array('class'=>'form-control required dateField','readonly'=>'readonly','placeholder'=>__('promotion.promotion_date'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('warning.description')</label>
											{!! Form::textarea('description',Input::old('description'), $attributes = array('class'=>'form-control description','id'=>'description','cols'=>'50','rows'=>'3','placeholder'=>__('warning.description'))) !!}
										</div>
									</div>
								</div>

								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											@if(isset($editModeData))
												@if($editModeData->status ==1)
													<input type="submit" name="update" class="btn btn-info btn_style" value="@lang('common.update')">
													<input name="submit" type="submit" class="btn btn-info btn_style" value="@lang('common.submit')">
												@endif
											@else
												<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
											@endif
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
	<script>

		$(document).on("change",".employee_id",function(){
			var employee_id  = $('.employee_id').val();
			if(employee_id  !='') {
				var action = "{{ URL::to('promotion/findEmployeeInfo') }}";
				$.ajax({
					type: 'POST',
					url: action,
					data: {'employee_id': employee_id, '_token': $('input[name=_token]').val()},
					success: function (data) {
						$('#current_department').val(data.department.department_id).trigger("change");
						$('#current_designation').val(data.designation.designation_id).trigger("change");
						$('#current_pay_grade').val(data.pay_grade.pay_grade_id).trigger("change");
						$('#current_salary').val(data.pay_grade.gross_salary);
					}
				});
			}else{
				$('#current_department').val('');
				$('#current_designation').val('');
				$('#current_pay_grade').val('');
                $('#current_salary').val('');
			}
		});

		$(document).on("change",".promoted_pay_grade",function(){
			var pay_grade_id  = $('.promoted_pay_grade').val();
			if(pay_grade_id  !='') {
				var action = "{{ URL::to('promotion/findPayGradeWiseSalary') }}";
				$.ajax({
					type: 'POST',
					url: action,
					data: {'pay_grade_id': pay_grade_id, '_token': $('input[name=_token]').val()},
					success: function (data) {
                        $('#new_salary').val(data.gross_salary);
					}
				});
			}else{
                $('#new_salary').val('');
			}
		});

		@if(isset($editModeData))
			@if($editModeData->status == 2)
				{!!  "$('#promotionForm').find('input').attr('readonly', true);" !!}
				{!!  "$('#promotionForm').find('textarea').attr('readonly', true);"!!}
				{!!  "$('#promotionForm').find('select').css('pointer-events', 'none');"!!}
				{!!  "$('#promotionForm').find('.select2').removeClass('select2');"!!}

			@endif
		@endif

	</script>
@endsection

