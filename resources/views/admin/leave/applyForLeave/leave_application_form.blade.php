@extends('admin.master')
@section('content')
@section('title')
@lang('leave.leave_application_form')
@endsection
<style>
	.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
		background: none;
		color: red !important;
		cursor: default;
	}
	td{
		color:black !important;
	}
</style>

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				  
				</ol>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{route('applyForLeave.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('leave.view_leave_applicaiton')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@lang('leave.leave_application_form')</div>
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

						{{ Form::open(array('route' => 'applyForLeave.store','enctype'=>'multipart/form-data','id'=>'leaveApplicationForm')) }}
							<div class="form-body">
								<div class="row">
									{!! Form::hidden('employee_id',(isset($getEmployeeInfo)) ? $getEmployeeInfo->employee_id:'',$attributes = array('class'=>'employee_id')) !!}
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('common.employee_name')<span class="validateRq">*</span></label>
											{!! Form::text('',(isset($getEmployeeInfo)) ? $getEmployeeInfo->first_name.' '.$getEmployeeInfo->last_name: '', $attributes = array('class'=>'form-control','readonly'=>'readonly')) !!}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('leave.leave_type')<span class="validateRq">*</span></label>
											{{ Form::select('leave_type_id',$leaveTypeList, Input::old('leave_type_id'), array('class' => 'form-control leave_type_id select2 required')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('leave.current_balance')<span class="validateRq">*</span></label>
											{!! Form::text('','', $attributes = array('class'=>'form-control current_balance','readonly'=>'readonly','placeholder'=>__('leave.current_balance'))) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label for="exampleInput">@lang('common.from_date')<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											{!! Form::text('application_from_date',Input::old('application_from_date'), $attributes = array('class'=>'form-control application_from_date','readonly'=>'readonly','placeholder'=>__('common.from_date'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<label for="exampleInput">@lang('common.to_date')<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											{!! Form::text('application_to_date',Input::old('application_to_date'), $attributes = array('class'=>'form-control application_to_date','readonly'=>'readonly','placeholder'=>__('common.to_date'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('leave.number_of_day')<span class="validateRq">*</span></label>
											{!! Form::text('number_of_day','', $attributes = array('class'=>'form-control number_of_day','readonly'=>'readonly','placeholder'=>__('leave.number_of_day'))) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('leave.purpose')<span class="validateRq">*</span></label>
											{!! Form::textarea('purpose', Input::old('purpose'), $attributes = array('class'=>'form-control purpose','id'=>'purpose','placeholder'=>__('leave.purpose'),'cols'=>'30','rows'=>'3')) !!}
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-6">
										<button type="submit" id="formSubmit" class="btn btn-info "><i class="fa fa-paper-plane"></i> @lang('leave.send_application')</button>
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
        jQuery(function (){

            $(document).on("focus", ".application_from_date", function () {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    startDate: new Date(),
                }).on('changeDate', function (e) {
                    $(this).datepicker('hide');
                });
            });

            $(document).on("focus", ".application_to_date", function () {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    startDate: new Date(),
                }).on('changeDate', function (e) {
                    $(this).datepicker('hide');
                });
            });

            $(document).on("change",".application_from_date,.application_to_date  ",function(){

                var application_from_date  = $('.application_from_date ').val();
                var application_to_date  = $('.application_to_date ').val();

                if(application_from_date !='' && application_to_date!=''  ){
                    var action = "{{ URL::to('applyForLeave/applyForTotalNumberOfDays') }}";
                    $.ajax({
                        type: 'POST',
                        url: action,
                        data: {'application_from_date': application_from_date,'application_to_date': application_to_date,'_token': $('input[name=_token]').val()},
                        dataType: 'json',
                        success: function (data) {
                            var currentBalance =  $('.current_balance').val();
                            if(data > currentBalance){
                                $.toast({
                                    heading: 'Warning',
                                    text: 'You have to apply '+ $('.current_balance').val() +' days!',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'warning',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                                $('body').find('#formSubmit').attr('disabled', true);
                                $('.number_of_day').val('');
                            }else if(data == 0){
                                $.toast({
                                    heading: 'Warning',
                                    text: 'You can not apply for leave !',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'warning',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                                $('body').find('#formSubmit').attr('disabled', true);
                                $('.number_of_day').val('');
                            }else{
                                $('.number_of_day').val(data);
                                $('body').find('#formSubmit').attr('disabled', false);
                            }
                        }
                    });
                }else{
                    $('body').find('#formSubmit').attr('disabled', true);
                }
            });

            $(document).on("change",".leave_type_id  ",function(){
                var leave_type_id  = $('.leave_type_id ').val();
                var employee_id  = $('.employee_id ').val();
                if(leave_type_id !='' && employee_id !='') {
                    var action = "{{ URL::to('applyForLeave/getEmployeeLeaveBalance') }}";
                    $.ajax({
                        type: 'POST',
                        url: action,
                        data: {'leave_type_id': leave_type_id,'employee_id': employee_id,'_token': $('input[name=_token]').val()},
                        dataType: 'json',
                        success: function (data) {
                            if(data == 0){
                                $.toast({
                                    heading: 'Warning',
                                    text: 'You have no leave balance !',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'warning',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                                $('.current_balance').val(data);
                                $('body').find('#formSubmit').attr('disabled', true);
                            }else{
                                $('.current_balance').val(data);
                                $('body').find('#formSubmit').attr('disabled', false);
                            }
                        }
                    });
                }else{
                    $('body').find('#formSubmit').attr('disabled', true);
                    $.toast({
                        heading: 'Warning',
                        text: 'Please select leave type !',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'warning',
                        hideAfter: 3000,
                        stack: 6
                    });
                    $('.current_balance').val('');
                }
            });

        });
	</script>
@endsection
