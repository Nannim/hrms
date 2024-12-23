@extends('admin.master')
@section('content')
@section('title')

@lang('termination.termination_list')
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
			<a href="{{ route('termination.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('termination.add_new_termination')</a>
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
										 <th>@lang('termination.subject')</th>
										 <th>@lang('termination.termination_type')</th>
										 <th>@lang('termination.notice_date')</th>
										 <th>@lang('termination.termination_date')</th>
                                        <th>@lang('termination.terminated_by')</th>
                                        <th>@lang('common.status')</th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
								</thead>
								<tbody>
								{!! $sl=null !!}
								@foreach($results AS $value)
									<tr class="{!! $value->termination_id !!}">
										<td style="width: 100px;">{!! ++$sl !!}</td>
										<td>@if(isset($value->terminateTo->first_name )) {{ $value->terminateTo->first_name }} {{ $value->terminateTo->last_name }} @endif</td>
										<td>{!! $value->subject !!}</td>
										<td>{!! $value->termination_type !!}</td>
										<td>{!! dateConvertDBtoForm($value->notice_date) !!}</td>
										<td>{!! dateConvertDBtoForm($value->termination_date) !!}</td>
										<td>@if(isset($value->terminateBy->first_name )) {{ $value->terminateBy->first_name }} {{ $value->terminateBy->last_name }} @endif</td>
										<td>
											@if($value->status == 1)
												<span class="label label-info">Pending</span>
											@else
												<span class="label label-success">Approved</span>
											@endif
										</td>
										<td style="width: 100px;">
											<a  title="View Details" href="{{route('termination.show',$value->termination_id)}}" class="btn btn-primary btn-xs btnColor">
												<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
											</a>
											@if($value->status !=2)
												<a href="{!! route('termination.edit',$value->termination_id) !!}"  class="btn btn-success btn-xs btnColor">
													<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
												</a>
												<a href="{!!route('termination.delete',$value->termination_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->termination_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
