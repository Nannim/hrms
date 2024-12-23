@extends('admin.master')
@section('content')
@section('title')
@lang('payment.my_payroll')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	

		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@lang('payment.my_payroll')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(count($results)>0)
							<div class="row">
								<div class="col-md-12 text-right">
									<h4 style="">
										<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadMyPayroll')}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
									</h4>
								</div>
							</div>
							@endif
							<div class="table-responsive">
								<table  id="" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>@lang('common.serial')</th>
											<th>@lang('common.month')</th>
											<th>@lang('employee.photo')</th>
											<th>@lang('common.employee_name')</th>
											<th>@lang('salary_sheet.pay_grade')</th>
											<th>@lang('paygrade.basic_salary')</th>
											<th>@lang('salary_sheet.gross_salary')</th>
											<th>@lang('common.status')</th>
											<th>@lang('common.action')</th>
										</tr>
									</thead>
									<tbody>
										@if(count($results)>0)
											{!! $sl=null !!}
											@foreach($results AS $value)
												<tr>
													<td style="width: 100px;">{!! ++$sl !!}</td>
													<td>
                                                        @php
															$monthAndYear   = explode('-',$value->month_of_salary);

															$month = $monthAndYear[1];
															$dateObj   = DateTime::createFromFormat('!m', $month);
															$monthName = $dateObj->format('F');
															$year = $monthAndYear[0];

															$monthAndYearName = $monthName." ".$year ;
															echo $monthAndYearName;
                                                       @endphp
													</td>
													<td>
														@if($value->employee->photo != '')
															<img style=" width: 70px; " src="{!! asset('uploads/employeePhoto/'.$value->employee->photo) !!}" alt="user-img" class="img-circle">
														@else
															<img style=" width: 70px; " src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle">
														@endif
													</td>
													<td>@if(isset($value->employee->first_name)){!!  $value->employee->first_name !!} {{$value->employee->last_name}}@endif</td>
													<td>@if(isset($value->employee->payGrade->pay_grade_name)){!!  $value->employee->payGrade->pay_grade_name !!} @endif</td>
													<td>{!! $value->basic_salary !!}</td>
													<td>{!! $value->gross_salary !!}</td>
													<td>
														<span class="label label-success">@lang('salary_sheet.paid')</span>
													</td>
													<td style="width: 100px">
															<a href="{{url('myPayroll/generatePayslip',$value->salary_details_id)}}" target="_blank"><button  class="btn btn-success waves-effect waves-light"><span>@lang('salary_sheet.generate_payslip')</span> </button></a>
													</td>

												</tr>
											@endforeach
										@else
											<tr>
												<td colspan="9">@lang('common.no_data_available') ! </td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


