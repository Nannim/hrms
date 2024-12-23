
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('payment.my_payroll')</title>
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
		.month{
			padding-top: 124px;
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
		.printHead{
			width: 35%;
			margin: 0 auto;
		}
	</style>
	<body>
	<div class="printHead">
		@if($printHead)
			{!! $printHead->description !!}
		@endif
		<br>
		<br>
	</div>
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							

							<div class="table-responsive">
								<table  id="myTable" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
										    <th>@lang('common.serial')</th>
											<th>@lang('common.month')</th>
											<th>@lang('common.employee_name')</th>
											<th>@lang('salary_sheet.pay_grade')</th>
											<th>@lang('paygrade.basic_salary')</th>
											<th>@lang('salary_sheet.gross_salary')</th>
											<th>@lang('common.status')</th>
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
													<td>@if(isset($value->employee->first_name)){!!  $value->employee->first_name !!} {{$value->employee->last_name}}@endif</td>
													<td>@if(isset($value->employee->payGrade->pay_grade_name)){!!  $value->employee->payGrade->pay_grade_name !!} @endif</td>
													<td>{!! $value->basic_salary !!}</td>
													<td>{!! $value->gross_salary !!}</td>
													<td>
														<span class="label label-success">@lang('salary_sheet.paid')</span>
													</td>

												</tr>
											@endforeach
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
</body>
</html>


