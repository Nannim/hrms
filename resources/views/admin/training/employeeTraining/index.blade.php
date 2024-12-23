@extends('admin.master')
@section('content')
@section('title')
@lang('training.employee_training_list')
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
				<a href="{{ route('trainingInfo.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('training.add_employee_training')</a>
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
											 <th>@lang('training.training_type')</th>
											 <th>@lang('training.subject')</th>
											 <th>@lang('training.training_duration')</th>
											<th>@lang('common.action')</th>
										</tr>
									</thead>
									<tbody>
										{!! $sl=null !!}
										@foreach($results AS $value)
											<tr class="{!! $value->training_info_id !!}">
												<td style="width: 100px;">{!! ++$sl !!}</td>
												<td>@if(isset($value->employee->first_name)) {!! $value->employee->first_name !!} {!! $value->employee->last_name !!} @endif</td>
												<td>@if(isset($value->trainingType->training_type_name)) {!! $value->trainingType->training_type_name !!}  @endif</td>
												<td>{{$value->subject}}</td>
												<td>{!! dateConvertDBtoForm($value->start_date) !!} To {!! dateConvertDBtoForm($value->end_date) !!}</td>
												<td style="width: 100px;">
													<a  title="View Details" href="{{route('trainingInfo.show',$value->training_info_id)}}" class="btn btn-primary btn-xs btnColor">
														<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
													</a>
													<a href="{!! route('trainingInfo.edit',$value->training_info_id ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('trainingInfo.delete',$value->training_info_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->training_info_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
