
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
			border-spacing: 0px;
		}
		table, td, th {border: 1px solid #ddd;}
		td{padding: 3px;}
		th{padding: 3px;}
		.text-center{
			text-align: center;
		}
		.companyAddress{
			width: 367px;
			margin: 0 auto;
		}
		.container {
			padding-right: 15px;
			padding-left: 15px;
			margin-right: auto;
			margin-left: auto;
			width: 95%;
		}
		.row {
			margin-right: -15px;
			margin-left: -15px;
		}
		.col-md-6 {
			width: 49%;
			float: left;
			padding-right: .5%;
			padding-left: .5%;
		}
		.div1{
			position: relative;
		}
		.div2{
			position: absolute;
			width: 100%;
			border: 1px solid;
			padding: 30px 12px 0px 12px;
		}
		.col-md-4 {
			width: 33.33333333%;
			float: left;
		}
		.clearFix{
			clear:both;
		}
		.padding{
			margin-bottom: 32px;

		}
	</style>
	<body>
	<div class="container">
		<div class="row">
			<div class=" companyAddress">
				<div class="headingStyle" style="margin-left: 30px;">
					@if($printHeadSetting){!! $printHeadSetting->description !!}@endif
				</div>
				<h3 style="    margin-left: 65px;"><strong>@lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance')</strong></h3>
			</div>
			<div class="div1">
				<div class="div2">
					<div class="clearFix">
						<div class="col-md-6">
							<table >
								<tbody>
								<tr>
									<td>@lang('common.name') :</td>
									<td ><b>{{$salaryDetails->first_name}} {{$salaryDetails->last_name}}</b></td>
								</tr>
								<tr>
									<td>@lang('employee.department') :</td>
									<td><b>{{$salaryDetails->department_name}}</b></td>
								</tr>
								<tr>
									<td>@lang('employee.designation') :</td>
									<td><b>{{$salaryDetails->designation_name}}</b></td>
								</tr>
								<tr>
									<td>@lang('employee.date_of_joining') : </td>
									<td><b>{{date(" d-M-Y", strtotime($salaryDetails->date_of_joining))}} </b></td>
								</tr>
								<tr>
									<td>@lang('salary_sheet.basic_salary') : </td>
									<td class="text-center">{{number_format($salaryDetails->basic_salary)}}</td>
								</tr>
								@if(count($salaryDetailsToAllowance) > 0)
									@foreach($salaryDetailsToAllowance as $allowance)
										<tr>
											<td>{{$allowance->allowance_name}}: </td>
											<td class="text-center"> {{number_format($allowance->amount_of_allowance)}}</td>
										</tr>
									@endforeach
								@endif


								<tr>
									<td>@lang('salary_sheet.net_salary') : </td>
									<td class="text-center" style="background: #ddd"> {{number_format($salaryDetails->net_salary)}}</td>
								</tr>
								<tr>
									<td>@lang('salary_sheet.taxable_salary') :  </td>
									<td class="text-center"> {{number_format($salaryDetails->taxable_salary)}}</td>
								</tr>
								<tr>
									<td>@lang('salary_sheet.income_tax_to_pay_for_the_month') :  </td>
									<td class="text-center"> {{number_format($salaryDetails->tax)}}</td>
								</tr>
								@php
									$companyTaxDeduction = 0;
                                    $companyTaxDeduction = ($salaryDetails->tax * 70) / 100;

                                    $employeeTaxDeduction = 0;
                                    $employeeTaxDeduction = ($salaryDetails->tax * 30) / 100;
								@endphp
								<tr>
									<td>@lang('salary_sheet.company_tax_deduction') :  </td>
									<td class="text-center"> {{number_format(round($companyTaxDeduction))}}</td>
								</tr>
								<tr>
									<td>@lang('salary_sheet.employee_tax_payable'):  </td>
									<td class="text-center"> {{number_format(round($employeeTaxDeduction))}}</td>
								</tr>
								@if(count($salaryDetailsToDeduction) > 0)
									@foreach($salaryDetailsToDeduction as $deduction)
										<tr>
											<td>{{$deduction->deduction_name}} :  </td>
											<td class="text-center"> {{number_format($deduction->amount_of_deduction)}}</td>
										</tr>
									@endforeach
								@endif
								@if($salaryDetails->total_late_amount !=0)
									<tr>
										<td>@lang('salary_sheet.late_amount') :  </td>
										<td class="text-center"> {{number_format($salaryDetails->total_late_amount)}}</td>
									</tr>
								@endif
								@if($salaryDetails->total_absence_amount !=0)
									<tr>
										<td>@lang('salary_sheet.absence_amount') :  </td>
										<td class="text-center"> {{number_format($salaryDetails->total_absence_amount)}}</td>
									</tr>
								@endif
								@if($salaryDetails->total_overtime_amount != 0)
									<tr>
										<td>@lang('salary_sheet.over_time') : </td>
										<td class="text-center"> {{number_format($salaryDetails->total_overtime_amount)}}</td>
									</tr>
								@endif
								<tr>
									<td> @lang('salary_sheet.net_salary_to_be_paid') :  </td>
									<td class="text-center" style="background: #ddd">  {{number_format($salaryDetails->gross_salary)}}   </td>
								</tr>
								<tr>
									<td>  @lang('salary_sheet.total_income_tax_deduction_for_the_financial_year') :  </td>
									<td class="text-center" >    {{number_format($financialYearTax->totalTax)}}  </td>
								</tr>

								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table">
								<tbody>
								<tr>
									<td >No. :  </td>
									<td > <b>1</b></td>
								</tr>
								<tr>
									<td>@lang('common.month') :   </td>
									<td> <b>{{convartMonthAndYearToWord($salaryDetails->month_of_salary)}}</b></td>
								</tr>
								<tr>
									<td>@lang('common.date') : </td>
									<td><b>{{date(" d-M-Y", strtotime(date('Y-m-d')))}} </b></td>
								</tr>
								<tr>
									<td>@lang('salary_sheet.number_of_working_days') :  </td>
									<td> <b>{{$salaryDetails->total_working_days}}</b></td>
								</tr>
								<tr>
									<td>  @lang('salary_sheet.number_of_worked_in_them_month')  :  </td>
									<td class="text-center">   {{$salaryDetails->total_present}}   </td>
								</tr>

								<tr>
									<td> @lang('salary_sheet.unjustified_absence')  :  </td>
									<td class="text-center">   {{$salaryDetails->total_absence}}   </td>
								</tr>
								<tr>
									<td>  @lang('salary_sheet.per_day_salary')  :  </td>
									<td class="text-center">   {{number_format($salaryDetails->per_day_salary)}}   </td>
								</tr>
								@if($salaryDetails->total_late !=0)
									<tr>
										<td>  @lang('salary_sheet.salary_deduction_for_late_attendance')  :  </td>
										<td class="text-center">   {{$salaryDetails->total_late}}   </td>
									</tr>
								@endif
								@if($salaryDetails->total_overtime_amount !=0)
									<tr>
										<td> @lang('salary_sheet.over_time')  :  </td>
										<td class="text-center">   {{$salaryDetails->total_over_time_hour}}   </td>
									</tr>
									<tr>
										<td> @lang('salary_sheet.over_rate')  :  </td>
										<td class="text-center">   {{$salaryDetails->overtime_rate}}  </td>
									</tr>
								@endif
								@if(count($salaryDetailsToLeave) > 0)
									@foreach($salaryDetailsToLeave as $leaveRecord)
										<tr>
											<td>  {{$leaveRecord->leave_type_name}} :  </td>
											<td class="text-center">   {{$leaveRecord->num_of_day}}   </td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="clearFix padding">
						<div class="col-md-4" style="text-align: center;">
							<strong>@lang('salary_sheet.adminstrator_signature') ...</strong>
						</div>
						<div class=" col-md-4" style="text-align: center;">
							<strong>@lang('common.date')  ...</strong>
						</div>
						<div class=" col-md-4" style="text-align: center;">
							<strong>@lang('salary_sheet.employee_signature') ...</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>


