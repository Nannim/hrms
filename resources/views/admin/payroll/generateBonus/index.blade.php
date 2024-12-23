@extends('admin.master')
@section('content')
@section('title')
@lang('bonus.bonus_list')
@endsection
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		   <ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>	
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<a href="{{ route('generateBonus.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('bonus.generate_bonus')</a>
		</div>	
	</div>
                
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @lang('bonus.bonus_list')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						@if(session()->has('success'))
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
							</div>
						@endif
						@if(session()->has('error'))
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
							</div>
						@endif
						<div class="table-responsive">
							<table id="myTable" class="table table-bordered">
								<thead>
									 <tr class="tr_header">
                                        <th>@lang('common.serial')</th>
                                        <th>@lang('common.month')</th>
                                        <th>@lang('common.employee_name')</th>
										 <th>@lang('salary_sheet.pay_grade')</th>
										 <th>@lang('bonus.festival_name')</th>
                                        <th>@lang('paygrade.gross_salary')</th>
                                        <th>@lang('paygrade.basic_salary')</th>
                                        <th>@lang('bonus.tax')</th>
                                        <th>@lang('bonus.bonus_amount')</th>
                                    </tr>
								</thead>
								<tbody>
									{!! $sl=null !!}
									@foreach($results AS $value)
										<tr class="{!! $value->employee_bonus_id !!}">
											<td style="width: 100px;">{!! ++$sl !!}</td>
											<td>{{$value->month }}</td>
											<td>@if(isset($value->employee->first_name)) {{$value->employee->first_name}} {{$value->employee->last_name}} @endif</td>
											<td>
												@if(isset($value->employee->payGrade->pay_grade_name)) {{$value->employee->payGrade->pay_grade_name}} (Monthly)@endif
												@if(isset($value->employee->hourlySalaries->hourly_grade)) {{$value->employee->hourlySalaries->hourly_grade}} (Hourly) @endif
											</td>
											<td>@if(isset($value->festivalName->festival_name)) {{$value->festivalName->festival_name}} @endif</td>
											<td>{{$value->gross_salary }}</td>
											<td>{{$value->basic_salary }}</td>
											<td>{{$value->tax }}</td>
											<td>{{$value->bonus_amount }}</td>
										</tr>
									@endforeach
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
