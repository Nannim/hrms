@extends('admin.master')
@section('content')
@section('title')
@lang('holiday.weekly_holiday_list')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	
			<div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
				<a href="{{ route('weeklyHoliday.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('holiday.add_weekly_holiday')</a>
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
									<thead class="tr_header">
										 <tr>
											<th>@lang('common.serial')</th>
											<th>@lang('holiday.weekly_holiday_name')</th>
											<th>@lang('common.status')</th>
											<th style="text-align: center;">@lang('common.action')</th>
										</tr>
									</thead>
									<tbody>
										{!! $sl=null !!}
										@foreach($results AS $value)
											<tr class="{!! $value->week_holiday_id !!}">
												<td style="width: 100px;">{!! ++$sl !!}</td>
												<td>{!! $value->day_name !!}</td>
												<td  style="width: 100px;">
													<span class="label label-{{ $value->status==2 ? 'warning' : 'success' }}">{{ $value->status==2 ? __('common.inactive') : __('common.active') }}</span>
												</td>
												<td style="width: 100px;">
													<a href="{!! route('weeklyHoliday.edit',$value->week_holiday_id ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('weeklyHoliday.delete',$value->week_holiday_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->week_holiday_id !!}" class="btnColor delete btn btn-danger btn-xs deleteBtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
