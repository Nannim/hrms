@extends('admin.master')
@section('content')
@section('title')
@lang('recruitement.job_post_list')
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
				<a href="{{ route('jobPost.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('recruitement.create_new_job_post')</a>
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
								<table  class="table table-hover manage-u-table">
									<thead>
									<tr>
										<th>@lang('common.serial')</th>
										<th>@lang('recruitement.job_title')</th>
										<th>@lang('recruitement.publish_by')</th>
										<th>@lang('recruitement.application_end_date')</th>
										<th>@lang('common.status')</th>
										<th>@lang('common.action')</th>
									</tr>
									</thead>
									<tbody>
									{!! $sl=null !!}
									@if(count($results) > 0)
										@foreach($results AS $value)
											<tr class="{!! $value->job_id !!}">
												<td style="width: 70px;">{!! ++$sl !!}</td>
												<td>{!! $value->job_title !!}
													<br/><span class="text-muted">Past : {!! $value->post !!}</span>
												</td>
												<td>@if(isset($value->createdBy->first_name)) {{$value->createdBy->first_name}} {{$value->createdBy->last_name}}@endif
													<br/><span class="text-muted">Published Date: {{date("d M Y", strtotime($value->created_at))}} </span>
												</td>
												<td>
													{{date("d M Y", strtotime($value->application_end_date))}}
												</td>
												<td>
													<span class="label label-{{ $value->status=='1' ? 'success' : 'warning' }}">{{ $value->status=='1' ? __('recruitement.published') : __('recruitement.unpublished') }}</span>
												</td>
												<td style="width: 100px;">
													<a title="View Notice" href="{{route('jobPost.show',$value->job_id)}}" class="btn btn-primary btn-xs btnColor">
														<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
													</a>
													<a href="{!! route('jobPost.edit',$value->job_id ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('jobPost.delete',$value->job_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->job_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="6">@lang('common.no_data_available')</td>
										</tr>
									@endif
									</tbody>
								</table>
								<div class="text-center">
									{{$results->links()}}
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
