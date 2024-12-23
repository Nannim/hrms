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
			@php
				$netSalary = 0;
				$totalOvertimeAmount = 0;
				$totalDeduction = 0;
				$sumOfTotalDeduction = 0;
			@endphp
			@if(isset($employeeDetails) || isset($allowances))

				@php
					$gross_salary = $employeeGrossSalary;
					$basic_salary = $employeeDetails->payGrade->basic_salary;
					$total_allowances = 0;
					if(count($allowances['allowanceArray'] ) > 0){
						foreach($allowances['allowanceArray'] as $a){
							$total_allowances +=$a['amount_of_allowance'];
						}
					}
					$net_salary = $basic_salary + $total_allowances;
					if($net_salary > $gross_salary){
						$basic_salary = $basic_salary - ($net_salary - $gross_salary);
					}else{
						 $basic_salary += $gross_salary - ($basic_salary + $total_allowances);
					}

				@endphp

			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @lang('salary_sheet.salary_sheet')/ @lang('salary_sheet.final_balance') </div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					{{ Form::open(array('route' => 'saveEmployeeSalaryDetails.store')) }}
					<div class="panel-body" style="    padding: 18px 49px;">
						<br>
						<div class="row" style="border: 1px solid #ddd;padding: 26px 9px">
								<div class="col-md-6">
									<table class="table table-bordered table-hover table-striped">
										<tbody>
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
												<td>@lang('salary_sheet.basic_salary') : </td>
												<td class="text-center adjustmentSalary">
													{{number_format( $basic_salary) }}
													@php $netSalary += $basic_salary; @endphp
												</td>
											</tr>
											@if(count($allowances['allowanceArray'] ) > 0)
												@foreach($allowances['allowanceArray'] as $allowance)
													@php $netSalary += $allowance['amount_of_allowance']; @endphp
													<tr>
														<td>{{$allowance['allowance_name']}}: </td>
														<td class="text-center"> {{number_format($allowance['amount_of_allowance'])}}</td>
														<input type="hidden"  name="allowance_id[]" value="{{$allowance['allowance_id']}}">
														<input type="hidden"  name="amount_of_allowance[]" value="{{$allowance['amount_of_allowance']}}">
													</tr>
												@endforeach
											@endif

											<tr>
												<td>@lang('salary_sheet.net_salary') : </td>
												<td class="text-center" style="background: #ddd"> {{number_format($netSalary)}}</td>
												<input type="hidden" name="net_salary" value="{{$netSalary}}">
											</tr>

											<tr>
												<td>@lang('salary_sheet.taxable_salary') :  </td>
												<td class="text-center"> {{number_format($taxAbleSalary)}}</td>
												<input type="hidden" name="taxable_salary" value="{{$taxAbleSalary}}">

											</tr>
											<tr>
												<td>@lang('salary_sheet.income_tax_to_pay_for_the_month') :  </td>
												<td class="text-center"> {{number_format($tax)}}</td>
												@php
													$netSalary -= $tax;
													$sumOfTotalDeduction += $tax;
												@endphp
											</tr>
											@php
												$companyTaxDeduction = 0;
                                                $companyTaxDeduction = ($tax * 70) / 100;

                                                $employeeTaxDeduction = 0;
                                                $employeeTaxDeduction = ($tax * 30) / 100;
											@endphp
											<tr>
												<td>@lang('salary_sheet.company_tax_deduction') :  </td>
												<td class="text-center"> {{number_format(round($companyTaxDeduction))}}</td>
											</tr>
											<tr>
												<td>@lang('salary_sheet.employee_tax_payable'):  </td>
												<td class="text-center"> {{number_format(round($employeeTaxDeduction))}}</td>
											</tr>
											@if(count($deductions['deductionArray']) > 0)
												@foreach($deductions['deductionArray'] as $deduction)
													@php $totalDeduction+= $deduction['amount_of_deduction'];@endphp
												<tr>
													<td>{{$deduction['deduction_name']}} :  </td>
													<td class="text-center"> {{number_format($deduction['amount_of_deduction'])}}</td>
													@php
														$netSalary -= $deduction['amount_of_deduction'];
														$sumOfTotalDeduction+=$deduction['amount_of_deduction'];
													@endphp
													<input type="hidden"  name="deduction_id[]" value="{{$deduction['deduction_id']}}">
													<input type="hidden"  readonly name="amount_of_deduction[]" value="{{$deduction['amount_of_deduction']}}">
												</tr>
												@endforeach
											@endif
											@if($employeeAllInfo['totalLateAmount'] != 0)
												<tr>
													<td>@lang('salary_sheet.late_amount') :  </td>
													<td class="text-center"> {{number_format($employeeAllInfo['totalLateAmount'])}}</td>
													@php
														$netSalary -= $employeeAllInfo['totalLateAmount'];
														$sumOfTotalDeduction +=$employeeAllInfo['totalLateAmount'];
													@endphp
													<input type="hidden"  name="total_late"  class="form-control deduction" value="{{$employeeAllInfo['dayOfSalaryDeduction']}}">
													<input type="hidden"  name="total_late_amount"  class="form-control deduction" value="{{$employeeAllInfo['totalLateAmount']}}">
												</tr>
											@endif
											@if($employeeAllInfo['totalAbsenceAmount'] != 0)
												<tr>
													<td>@lang('salary_sheet.absence_amount') :  </td>
													<td class="text-center"> {{number_format($employeeAllInfo['totalAbsenceAmount'])}}</td>
													@php
														$netSalary -= $employeeAllInfo['totalAbsenceAmount'];
														$sumOfTotalDeduction +=$employeeAllInfo['totalAbsenceAmount'];
													@endphp
												</tr>
											@endif
											@if($employeeAllInfo['totalOvertimeAmount'] != 0)
												<tr>
													<td>@lang('salary_sheet.over_time') : </td>
													<td class="text-center"> {{number_format($employeeAllInfo['totalOvertimeAmount'])}}</td>
													@php
														$netSalary += $employeeAllInfo['totalOvertimeAmount'];
														$totalOvertimeAmount +=$employeeAllInfo['totalOvertimeAmount'];
													@endphp
													<input type="hidden" name="overtime_rate" class="form-control allowance" value="{{$employeeAllInfo['overtime_rate']}}">
													<input type="hidden" name="total_over_time_hour" class="form-control allowance" value="{{$employeeAllInfo['totalOverTimeHour']}}">
													<input type="hidden" name="total_overtime_amount" class="form-control allowance" value="{{$employeeAllInfo['totalOvertimeAmount']}}">
												</tr>
											@endif
											<tr>
												<td> @lang('salary_sheet.net_salary_to_be_paid') :  </td>
												<td class="text-center" style="background: #ddd">  {{number_format($netSalary)}}   </td>
											</tr>
											<tr>
												<td>  @lang('salary_sheet.total_income_tax_deduction_for_the_financial_year') :  </td>
												<td class="text-center" >   {{number_format($financialYearTax->totalTax)}}   </td>
											</tr>
										</tbody>
									</table>
								</div>
							<input type="hidden"  name="basic_salary" value="{{$basic_salary}}">
							<input type="hidden" name="month_of_salary" value="{{$month}}">
							<input type="hidden" name="total_working_days" value="{{$employeeAllInfo['totalWorkingDays']}}">
							<input type="hidden" name="total_present" value="{{$employeeAllInfo['totalPresent']}}">
							<input type="hidden" name="total_leave" value="{{$employeeAllInfo['totalLeave']}}">
							<input type="hidden" name="employee_id" value="{{$employee_id}}">
							<input type="hidden" name="action" value="monthlySalary">
							<input type="hidden" name="tax" readonly  class="form-control tax" value="{{$tax}}">
							<input type="hidden"  name="total_absence_amount"  class="form-control deduction" value="{{$employeeAllInfo['totalAbsenceAmount']}}">
							<input type="hidden" name="total_absence"  class="form-control deduction" value="{{$employeeAllInfo['totalAbsence']}}">
							<input type="hidden"   class="form-control total_allowance" name="total_allowance" value="{{$allowances['totalAllowance']+$totalOvertimeAmount}}">

							<div class="col-md-6">
									<table class="table table-bordered table-hover table-striped">
										<tbody>
											<tr>
												<td class="col-md-6">No. :  </td>
												<td class="col-md-6"> <b>1</b></td>
											</tr>
											<tr>
												<td>@lang('common.month') :   </td>
												<td> <b>{{convartMonthAndYearToWord($month)}}</b></td>
											</tr>
											<tr>
												<td>@lang('salary_sheet.number_of_working_days') :  </td>
												<td> <b>{{$employeeAllInfo['totalWorkingDays']}}</b></td>
											</tr>
											<tr>
												<td> @lang('salary_sheet.number_of_worked_in_them_month')  :  </td>
												<td class="text-center">   {{$employeeAllInfo['totalPresent']}}   </td>
											</tr>
											{{--<tr>--}}
												{{--<td>  Number of govt. holiday worked in the month :  </td>--}}
												{{--<td class="text-center">   10   </td>--}}
											{{--</tr>--}}
											<tr>
												<td> @lang('salary_sheet.unjustified_absence') :  </td>
												<td class="text-center">   {{$employeeAllInfo['totalAbsence']}}   </td>
											</tr>
											<tr>
												<td>  @lang('salary_sheet.per_day_salary')  :  </td>
												<td class="text-center">   {{number_format($employeeAllInfo['oneDaysSalary'])}}   </td>
												<input type="hidden" name="per_day_salary" value="{{$employeeAllInfo['oneDaysSalary']}}">
											</tr>
											@if($employeeAllInfo['dayOfSalaryDeduction'] !=0)
												<tr>
													<td>  @lang('salary_sheet.salary_deduction_for_late_attendance')  :  </td>
													<td class="text-center">   {{$employeeAllInfo['dayOfSalaryDeduction']}}   </td>
												</tr>
											@endif
											@if($employeeAllInfo['totalOvertimeAmount'] !=0)
												<tr>
													<td>  @lang('salary_sheet.over_time')  :  </td>
													<td class="text-center">   {{$employeeAllInfo['totalOverTimeHour']}}   </td>
												</tr>
												<tr>
													<td>  @lang('salary_sheet.over_rate') :  </td>
													<td class="text-center">   {{$employeeAllInfo['overtime_rate']}}   </td>
												</tr>
											@endif
											@if(count($leaveRecords) > 0)
												@foreach($leaveRecords as $leaveRecord)
													<tr>
														<td>  {{$leaveRecord->leave_type_name}} :  </td>
														<td class="text-center">   {{$leaveRecord->number_of_day}}   </td>
														<input type="hidden"  name="num_of_day[]" value="{{$leaveRecord->number_of_day}}">
														<input type="hidden"  name="leave_type_id[]" value="{{$leaveRecord->leave_type_id}}">
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								<input type="hidden"  class="form-control total_deduction" name="total_deduction" value="{{$sumOfTotalDeduction}}">
								<input type="hidden" readonly name="gross_salary" class="form-control gross_salary" value="{{round($netSalary)}}">
						</div>
						<br>
						<div class="col-md-12 text-center">
							<div class="form-group">
								<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
							</div>
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</div>
			@endif
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
