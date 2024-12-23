@extends('admin.master')
@section('content')
@section('title')
@lang('warning.warning_list')
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
			<a href="{{ route('warning.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('warning.add_warning')</a>
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
                                        <th>S/L</th>
                                        <th>@lang('common.employee_name')</th>
                                        <th>@lang('warning.warning_date')</th>
                                        <th>@lang('warning.subject')</th>
                                        <th>@lang('warning.warning_type')</th>
                                        <th>@lang('warning.warning_by')</th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
								</thead>
								<tbody>
								{!! $sl=null !!}
								@foreach($results AS $value)
									<tr class="{!! $value->warning_id !!}">
										<td style="width: 100px;">{!! ++$sl !!}</td>
										<td>@if(isset($value->warningTo->first_name )) {{ $value->warningTo->first_name }} {{ $value->warningTo->last_name }} @endif</td>
										<td>{!! dateConvertDBtoForm($value->warning_date) !!}</td>
										<td>{!! $value->subject !!}</td>
										<td>{!! $value->warning_type !!}</td>
										<td>@if(isset($value->warningBy->first_name )) {{ $value->warningBy->first_name }} {{ $value->warningBy->last_name }} @endif</td>
										<td style="width: 100px;">
											<a  title="View Details" href="{{route('warning.show',$value->warning_id)}}" class="btn btn-primary btn-xs btnColor">
												<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
											</a>
											<a href="{!! route('warning.edit',$value->warning_id) !!}"  class="btn btn-success btn-xs btnColor">
												<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											</a>
											<a href="{!!route('warning.delete',$value->warning_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->warning_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
