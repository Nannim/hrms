
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('salary_sheet.employee_payslip')</title>
		<meta charset="utf-8">
	</head>
	<style>

		table {
			margin: 0 0 40px 0;
			width: 100%;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			display: table;
			border-collapse: collapse;
		}
		table, td, th {border: 1px solid black;}
		td{padding: 5px;}
		th{padding: 5px;}
		/*.companyAddress{*/
			/*width: 75%;*/
			/*float: left;*/
		/*}*/
		/*.employeeInfo{*/
			/*width: 35%;*/
			/*float: right;*/
		/*}*/
		.month{
			text-align: center;
		}
		.col-md-4 {
			width: 33.33333333%;
			float: left;

		}
		.col-md-6 {
			width: 50%;
			float: left;
		}
		.col-md-12 {
			width: 100%;
		}
		.col-md-2 {
			width: 16.66666667%;
			float: left;
		}
	</style>
	<body>
	<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">

				<div class="companyAddress">
					<div style="    width: 300px;
    margin: 0 auto;" >
						@if($printHeadSetting){!! $printHeadSetting->description !!}@endif
					</div>
				</div>

				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<div class="col-md-12 month">
							<h3><strong>@lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance')</strong></h3>
						</div>
						<div class="form-body">
							<div class="table-responsive">
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
										<td>@lang('common.name'):</td>
										<td>
											<b>

													@if(isset($salaryDetails->employee->first_name))
														{{$salaryDetails->employee->first_name}} {{$salaryDetails->employee->last_name}}
													@endif
											</b>
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

								<div class="col-sm-12 col-xs-12 col-md-4" style="text-align: center">
									<strong>@lang('salary_sheet.adminstrator_signature') ..</strong>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-4" style="text-align: center">
									<strong>@lang('common.date') ..</strong>

								</div>
								<div class="col-sm-12 col-xs-12 col-md-4" style="text-align: center">
									<strong>@lang('salary_sheet.employee_signature') ..</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>


