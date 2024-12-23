@extends('admin.master')
@section('content')
@section('title')
@lang('salary_sheet.generate_salary_sheet')
@endsection
<style>
	.table>tbody>tr>td {
		padding: 5px 7px;
	}
	.address{
		margin-top: 22px;
	}
	.employeeName{
		position: relative;
	}
	#employee_id-error{
		position: absolute;
		top: 66px;
		left: 0;
		width: 100%he;
		width: 100%;
		height: 100%;
	}
	.icon-question {
		color: #7460ee;
		font-size: 16px;
		vertical-align: text-bottom;
	}

</style>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>

			</ol>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<a href="{{route('generateSalarySheet.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('salary_sheet.generate_payslip')</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @yield('title')</div>
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
								&nbsp;<strong>{{ session()->get('error') }}</strong>
							</div>
						@endif
						{{ Form::open(array('route' => 'generateSalarySheet.calculateEmployeeSalary','method'=>'GET','id'=>'calculateEmployeeSalaryForm')) }}
						<div class="form-body">
							<div class="row">
								<div class="col-md-offset-2 col-md-3">
									<div class="form-group employeeName">
										<label for="exampleInput">@lang('common.employee')<span class="validateRq">*</span></label>
										{{ Form::select('employee_id',$employeeList, (isset($employee_id)) ? $employee_id : '', array('class' => 'form-control employee_id select2 required')) }}
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('common.month')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										{!! Form::text('month', (isset($month)) ? $month : '', $attributes = array('class'=>'form-control required monthField','id'=>'month','placeholder'=>__('common.month'))) !!}
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="submit" class="btn btn-info " style="margin-top: 24px"> @lang('salary_sheet.generate_salary')</button>
									</div>
								</div>
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
            <?php
				$grossSalary = 0;
            ?>
			<div class="panel panel-info">

				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @lang('salary_sheet.generate_salary_sheet')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">

						<div class="form-body">
							{{ Form::open(array('route' => 'saveEmployeeSalaryDetails.store')) }}
							<div class="col-md-12 text-center">

								<h3><strong>@lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance') </strong></h3>
							</div>
							<div class="row">
								<div class="col-md-offset-2 col-md-8">
									<table class="table table-bordered table-hover table-striped">
										<tbody>
										<tr>
											<td>@lang('common.month') :   </td>
											<td> <b>{{convartMonthAndYearToWord($month)}}</b></td>
										</tr>
										<tr>
											<td>@lang('salary_sheet.pay_grade') :   </td>
											<td> <b>@if(isset($employeeDetails->hourlySalaries->hourly_grade)) {{$employeeDetails->hourlySalaries->hourly_grade}} @endif</b>(Hourly)</td>
										</tr>
										<tr>
											<td class="col-md-6">@lang('common.name') :</td>
											<td class="col-md-6"><b>{{$employeeDetails->first_name}} {{$employeeDetails->last_name}}</b></td>
										</tr>
										<tr>
											<td>@lang('employee.department') :</td>
											<td><b>@if(isset($employeeDetails->department->department_name)) {{$employeeDetails->department->department_name}} @endif</b></td>
										</tr>
										<tr>
											<td>@lang('employee.designation') :</td>
											<td><b>@if(isset($employeeDetails->designation->designation_name)) {{$employeeDetails->designation->designation_name}} @endif</b></td>
										</tr>
										<tr>
											<td>@lang('employee.date_of_joining') : </td>
											<td><b> {{date(" d-M-Y", strtotime($employeeDetails->date_of_joining))}}</b></td>
										</tr>

										<tr>
											<td>@lang('salary_sheet.working_hour')</td>
											<td class="text-center">
												{{$totalWorkingHour}}
												<input type="hidden" readonly  class="form-control" value="{{$totalWorkingHour}}" name="working_hour">
											</td>
										</tr>
										<tr>
											<td>@lang('paygrade.hourly_rate')</td>
											<td class="text-center">
												{{number_format($hourly_rate)}}
												<input type="hidden" readonly  class="form-control" value="{{$hourly_rate}}" name="hourly_rate">
											</td>
										</tr>
										<tr>
											<td >@lang('salary_sheet.total_salary')</td>
											<td class="text-center">
												{{number_format($totalSalary)}}
											</td>
										</tr>
										<input type="hidden" name="action" value="hourlySalary">
										<input type="hidden" name="employee_id" value="{{$employee_id}}">
										<input type="hidden" name="month_of_salary" value="{{$month}}">
										<tr>
											<td colspan="1" ><b>@lang('paygrade.gross_salary')</b></td>
											<td class="text-center">
												<b>{{number_format($totalSalary)}}</b>
												<input type="hidden" readonly  class="form-control gross_salary" name="gross_salary" value="{{$totalSalary}}">
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
								</div>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
				
		</div>
	</div>
</div>
@endsection

@section('page_scripts')
	<script type="text/javascript">
        jQuery(function(){
            $("#calculateEmployeeSalaryForm").validate();
        });
	</script>
@endsection
