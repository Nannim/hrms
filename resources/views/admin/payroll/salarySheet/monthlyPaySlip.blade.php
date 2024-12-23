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
				<div class="col-md-12 text-right">
					<h4 >
						<a class="btn btn-success"
						style="color: #fff" href="{{ URL('downloadPayslip/'.$paySlipId)}}"><i class="fa fa-download fa-lg"
						 aria-hidden="true"></i> @lang('common.download') PDF</a>
					</h4>
				</div>

				<div class="row" style="margin-top: 25px">

					<div class="col-md-12 text-center">

						<h3><strong> @lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance') </strong></h3>
					</div>
				</div>

				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body" style="    padding: 18px 49px;">
						<div class="row" style="border: 1px solid #ddd;padding: 26px 9px">
							<div class="col-md-6">
								<table class="table table-bordered table-hover table-striped">
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
								<table class="table table-bordered table-hover table-striped">
									<tbody>
									<tr>
										<td class="col-md-6">No. :  </td>
										<td class="col-md-6"> <b>1</b></td>
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
											<td>  @lang('salary_sheet.over_time')  :  </td>
											<td class="text-center">   {{$salaryDetails->total_over_time_hour}}   </td>
										</tr>
										<tr>
											<td>  @lang('salary_sheet.over_rate')  :  </td>
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
							<div class="row">
								<div class="col-md-6"></div>
								<div class="col-md-6"></div>
							</div>
							<div class="col-md-4">
								<p style="font-weight: 500;">@lang('salary_sheet.adminstrator_signature') ....</p>
							</div>
							<div class="col-md-4 text-center">
								<p style="font-weight: 500;"> @lang('common.date') .... </p>
							</div>
							<div class="col-md-4 text-right">
								<p style="font-weight: 500;"> @lang('salary_sheet.employee_signature') .... </p>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
