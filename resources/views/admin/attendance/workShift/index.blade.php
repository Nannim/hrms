@extends('admin.master')
@section('content')
@section('title')
@lang('work_shift.work_shift_list')
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
				<a href="{{ route('workShift.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('work_shift.add_work_shift')</a>
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
											<th>@lang('work_shift.work_shift_name')</th>
											<th>@lang('work_shift.start_time')</th>
											<th>@lang('work_shift.end_time')</th>
											<th>@lang('work_shift.late_count_time')</th>
											<th style="text-align: center;">@lang('common.action')</th>
										</tr>
									</thead>
									<tbody>
										{!! $sl=null !!}
										@foreach($results AS $value)
											<tr class="{!! $value->work_shift_id !!}">
												<td style="width: 100px;">{!! ++$sl !!}</td>
												<td>{!! $value->shift_name !!}</td>
												<td>{!! date("h:i a", strtotime($value->start_time)) !!}</td>
												<td>{!! date("h:i a", strtotime($value->end_time)) !!}</td>
												<td>{!! date("h:i a", strtotime($value->late_count_time)) !!}</td>
												<td style="width: 100px;">
													<a href="{!! route('workShift.edit',$value->work_shift_id ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('workShift.delete',$value->work_shift_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->work_shift_id !!}" class="btnColor delete btn btn-danger btn-xs deleteBtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
