@extends('admin.master')
@section('content')
@section('title')
@lang('payment.payment_history')
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
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@lang('payment.all_payment_history')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							{{ Form::open(array('route' => 'paymentHistory.paymentHistory','id'=>'paymentHistory','class'=>'paymentHistory')) }}
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="exampleInput">@lang('common.month')</label>
											{!! Form::text('month',isset($month)?$month : '', $attributes = array('class'=>'form-control monthField required','id'=>'month','placeholder'=>__('payment.enter_month'),'readonly'=>'readonly')) !!}
										</div>
									</div>
									<div class="col-md-6">
										<button type="submit" class="btn btn-info filter" style="margin-top: 26px;width: 106px;"> @lang('common.filter')</button>
									</div>
								</div>
							{{ Form::close() }}
							<br>
							@if(!empty($results) && isset($results))
							<div class="table-responsive">
								<table  id="" class="table table-bordered">
									<thead>
									<tr class="tr_header">
										<th>@lang('common.serial')</th>
										<th>@lang('common.employee_name')</th>
										<th>@lang('salary_sheet.pay_grade')</th>
										<th>@lang('salary_sheet.net_salary')</th>
										<th>@lang('payment.to_be_paid')</th>
									</tr>
									</thead>
									<tbody>

									@if(count($results) > 0)

										@php
											$sl = null;
											$totalNetSalary = 0;
										@endphp
										@foreach($results AS $value)
											<tr>
												<td style="width: 100px;">{!! ++$sl !!}</td>
												<td>
													{!!  $value->fullName !!}
													<br>
													<span class="text-muted">Department : {{$value->department_name}}</span>
												</td>
												<td>
													@if($value->pay_grade_name !='')
														{{$value->pay_grade_name}} (Monthly)
													@else
														{{$value->hourly_grade}} (Hourly)
													@endif
												</td>
												@php
													$sl = null;
                                                    $totalNetSalary += $value->gross_salary;
												@endphp
												<td>{!! number_format($value->gross_salary) !!}</td>
												<td>{!! number_format($value->gross_salary) !!}</td>
											</tr>
										@endforeach
										<tr>
											<td colspan="3" class="text-right"><b>@lang('payment.total')</b></td>
											<td><b>{{number_format($totalNetSalary)}}</b></td>
											<td><b>{{number_format($totalNetSalary)}}</b></td>
										</tr>
									@else
										<tr>
											<td colspan="9">@lang('common.no_data_available') ! </td>
										</tr>
									@endif
									</tbody>
								</table>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('page_scripts')
	<script>
        $(function() {
            $("#paymentHistory").validate();
        });

	</script>
@endsection

