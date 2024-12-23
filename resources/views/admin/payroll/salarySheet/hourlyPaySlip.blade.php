@extends('admin.master')
@section('content')
@section('title')
@lang('salary_sheet.employee_payslip')
@endsection
<style>
	.table>tbody>tr>td {
		padding: 5px 7px;
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

	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div  class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @lang('salary_sheet.employee_payslip')</div>

				<div class="row">
					<div class="col-md-12">
						<h4 style="margin-left: 22px;">
							<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadPayslip/'.$paySlipId)}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
						</h4>
					</div>
				</div>

				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<div class="form-body">

							<div class="col-md-12 text-center">

								<h3><strong>@lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance') </strong></h3>
							</div>
							<div class="row">
								<div class="col-md-offset-2 col-md-8">
									<table class="table table-bordered table-hover table-striped">
										<tbody>
										<tr>
											<td>@lang('common.month') :   </td>
											<td> <b>{{convartMonthAndYearToWord($salaryDetails->month_of_salary)}}</b></td>
										</tr>
										<tr>
											<td>@lang('salary_sheet.pay_grade') :   </td>
											<td> <b>@if(isset($salaryDetails->employee->hourlySalaries->hourly_grade))
														{{$salaryDetails->employee->hourlySalaries->hourly_grade}} (Hourly)
													@endif</b></td>
										</tr>
										<tr>
											<td class="col-md-6">@lang('common.name') :</td>
											<td class="col-md-6"><b>
													@if(isset($salaryDetails->employee->first_name))
														{{$salaryDetails->employee->first_name}} {{$salaryDetails->employee->last_name}}
													@endif</b>
											</td>
										</tr>
										<tr>
											<td>@lang('employee.department') :</td>
											<td><b>@if(isset($salaryDetails->employee->department->department_name))
														{{$salaryDetails->employee->department->department_name}}
													@endif</b></td>
										</tr>
										<tr>
											<td>@lang('employee.designation') :</td>
											<td><b>@if(isset($salaryDetails->employee->designation->designation_name))
														{{$salaryDetails->employee->designation->designation_name}}
													@endif</b></td>
										</tr>
										<tr>
											<td>@lang('employee.date_of_joining') : </td>
											<td><b>@if(isset($salaryDetails->employee->date_of_joining))
														{{date(" d-M-Y", strtotime($salaryDetails->employee->date_of_joining))}}
													@endif
													</b></td>
										</tr>

										<tr>
											<td>@lang('salary_sheet.working_hour')</td>
											<td class="text-center">
												{{$salaryDetails->working_hour}}
											</td>
										</tr>
										<tr>
											<td>@lang('paygrade.hourly_rate')</td>
											<td class="text-center">
												{{number_format($salaryDetails->hourly_rate)}}
												<input type="hidden" readonly  class="form-control" value="{{$salaryDetails->hourly_rate}}" name="hourly_rate">
											</td>
										</tr>
										<tr>
											<td >@lang('salary_sheet.total_salary')</td>
											<td class="text-center">
												{{number_format($salaryDetails->gross_salary)}}
											</td>
										</tr>

										<tr>
											<td colspan="1" ><b>@lang('paygrade.gross_salary')</b></td>
											<td class="text-center">
												<b>{{number_format($salaryDetails->gross_salary)}}</b>
											</td>
										</tr>

										</tbody>
									</table>
									<div class="col-sm-12 col-xs-12 col-md-4">
										<strong>@lang('salary_sheet.adminstrator_signature') ....</strong>
									</div>
									<div class="col-sm-12 col-xs-12 col-md-4">
										<strong>@lang('common.date') ....</strong>

									</div>
									<div class="col-sm-12 col-xs-12 col-md-4">
										<strong>@lang('salary_sheet.employee_signature') ....
										</strong>
									</div>
								</div>



							</div>
							<br>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

