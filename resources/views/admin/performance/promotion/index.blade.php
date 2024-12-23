@extends('admin.master')
@section('content')
@section('title')
@lang('promotion.employee_promotion_list')
@endsection
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		   <ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>	
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<a href="{{ route('promotion.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('promotion.add_employee_promotion')</a>
		</div>	
	</div>
                
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
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
                                        <th>@lang('common.employee_name')</th>
                                        <th>@lang('promotion.promotion_date')</th>
                                        <th>@lang('promotion.promoted_department')</th>
                                        <th>@lang('promotion.promoted_designation')</th>
                                        <th>@lang('promotion.promoted_paygrade')</th>
                                        <th>@lang('promotion.promoted_salary')</th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
								</thead>
								<tbody>
								{!! $sl=null !!}
								@foreach($results AS $value)
									<tr class="{!! $value->promotion_id !!}">
										<td style="width: 100px;">{!! ++$sl !!}</td>
										<td>@if(isset($value->employee->first_name)) {{ $value->employee->first_name }} {{ $value->employee->last_name }}@endif</td>
										<td>{!! dateConvertDBtoForm($value->promotion_date) !!}</td>
										<td>
											@if(isset($value->currentDepartment->department_name)) {{ $value->currentDepartment->department_name }}@endif
											<b>To</b>
											@if(isset($value->promotedDepartment->department_name)) {{ $value->promotedDepartment->department_name }}@endif
										</td>
										<td>
											@if(isset($value->currentDesignation->designation_name)) {{ $value->currentDesignation->designation_name }}@endif
											<b>To</b>
											@if(isset($value->promotedDesignation->designation_name)) {{ $value->promotedDesignation->designation_name }}@endif
										</td>
										<td>
											@if(isset($value->currentPayGrade->pay_grade_name)) {{ $value->currentPayGrade->pay_grade_name }}@endif
											<b>To</b>
											@if(isset($value->promotedPayGrade->pay_grade_name)) {{ $value->promotedPayGrade->pay_grade_name }}@endif
										</td>
										<td>
											{{$value->current_salary}}
											<b>To</b>
											{{$value->new_salary}}
										</td>
										<td style="width: 100px;">
											@if($value->status == 1)
												<a href="{!! route('promotion.edit',$value->promotion_id) !!}"  class="btn btn-success btn-xs btnColor">
													<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
												</a>
												<a href="{!!route('promotion.delete',$value->promotion_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->promotion_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											@endif
										</td>
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
