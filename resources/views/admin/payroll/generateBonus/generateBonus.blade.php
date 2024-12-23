@extends('admin.master')
@section('content')
@section('title')
@lang('bonus.generate_bonus')
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
			<a href="{{route('generateBonus.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('bonus.view_bonus_list')</a>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							<div id="searchBox">
								{{ Form::open(array('route' => 'generateBonus.filter','id'=>'generateBonus','method'=>'GET')) }}
								<div class="col-md-2"></div>
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label class="control-label" for="email">@lang('bonus.festival_name')<span class="validateRq">*</span></label>
										<select class="form-control employee_id select2 required" required name="bonus_setting_id">
											<option value="">---- @lang('common.please_select') ----</option>
											@foreach($bonusList as $value)
												<option value="{{$value->bonus_setting_id}}" @if(isset($_REQUEST['bonus_setting_id'])) @if($_REQUEST['bonus_setting_id'] == $value->bonus_setting_id) {{"selected"}} @endif @endif>{{$value->first_name}} {{$value->festival_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label class="control-label" for="email">@lang('common.month')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control monthField required" readonly placeholder="@lang('common.month')"  name="month" value="@if(isset($_REQUEST['month'])) {{$_REQUEST['month']}}@else {{ date('Y-m') }} @endif">
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<input type="submit" id="filter" style="margin-top: 25px; width: 100px;" class="btn btn-info " value="@lang('common.filter')">
									</div>
								</div>
								{{ Form::close() }}
							</div>
							</div>
					<br>
						@if(isset($results))
							<h4 class="text-right">
								{{--<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadMonthlyAttendance/?bonus_setting_id='.$_REQUEST['bonus_setting_id'].'&from_date='.$_REQUEST['month'].'&to_date=')}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> Download PDF</a>--}}
							</h4>
						@endif


						@if(isset($results))
							{{ Form::open(array('route' => 'saveEmployeeBonus.store')) }}
							<div class="table-responsive">
								<table class="table table-hover manage-u-table">
									<thead>
									<tr>
										<th style="width:100px;">@lang('common.serial')</th>
										<th>@lang('common.name')</th>
										<th>@lang('salary_sheet.pay_grade')</th>
										<th>@lang('paygrade.gross_salary')</th>
										<th>@lang('paygrade.basic_salary')</th>
										<th>@lang('bonus.net_bonus')</th>
										<th>@lang('bonus.tax')</th>
										<th>@lang('bonus.total_bonus')</th>
									</tr>
									</thead>
									<tbody>
									@php
										$sl = 1;
									@endphp
									@if(count($results) > 0)
										@foreach($results as $key => $value)
											<tr>
												<td colspan="8"><b>{{$key}}</b></td>
											</tr>
											@foreach($value as $k => $v)
												<tr>
													<td>{{++$k}}</td>
													<td><span class="font-medium">{{$v['fullName']}}</span>
														<br><span class="text-muted">{{$v['designation_name']}}</span>
													</td>

													@if($v['pay_grade_name'] !='')
														<td><span class="font-medium">{{$v['pay_grade_name']}} (Monthly)	</span></td>
													@else
														<td><span class="font-medium">{{$v['hourly_grade']}} (Hourly)	</span>
															<br><span class="text-muted">Hourly Rate : {{$v['hourly_rate']}}</span>
														</td>
													@endif

													<td><span class="font-medium">{{$v['gross_salary']}}</span></td>
													<td><span class="font-medium">{{$v['basic_salary']}}</span></td>
													<td><span class="font-medium">{{$v['net_bonus']}}</span></td>
													<td><span class="font-medium">{{$v['tax']}}</span></td>
													<td><span class="font-medium">{{$v['net_bonus'] - $v['tax']}}</span></td>

													<input type="hidden" name="employee_id[]" value="{{$v['employee_id']}}">
													<input type="hidden" name="gross_salary[]" value="{{$v['gross_salary']}}">
													<input type="hidden" name="basic_salary[]" value="{{$v['basic_salary']}}">
													<input type="hidden" name="bonus_amount[]" value="{{$v['net_bonus'] - $v['tax']}}">
													<input type="hidden" name="tax[]" value="{{$v['tax']}}">
												</tr>
											@endforeach
										@endforeach
										<input type="hidden" name="month" value="{{$_REQUEST['month']}}">
										<input type="hidden" name="bonus_setting_id" value="{{$_REQUEST['bonus_setting_id']}}">
									@else
										<tr>
											<td colspan="8"> No data have found..</td>
										</tr>
									@endif


									</tbody>
								</table>
							</div>
							@if(count($results) > 0)
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12 text-center">
										<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
									</div>
								</div>
							</div>
							@endif

							{{ Form::close() }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('page_scripts')
<style>
	.employeeName{
		position: relative;
	}
	#bonus_setting_id-error{
		position: absolute;
		top: 66px;
		left: 0;
		width: 100%he;
		width: 100%;
		height: 100%;
	}
</style>
<script>
    jQuery(function (){
        $("#generateBonus").validate();
    });
</script>
@endsection