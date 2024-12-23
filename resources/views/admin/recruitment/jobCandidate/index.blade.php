@extends('admin.master')
@section('content')
@section('title')
@lang('recruitement.job_candidate_list')
@endsection
<style>
	.applicatioFontStyle{
		padding: 8px;
		border-radius: 50%;
		background: #757575;
		color: #fff;
	}
</style>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-7 col-md-7 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
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
										<th>@lang('recruitement.job_application')</th>
										<th>@lang('recruitement.short_listed_application')</th>
										<th>@lang('recruitement.reject_application')</th>
										<th>@lang('recruitement.job_interview')</th>
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
											<td style="font-size: 14px;font-weight: 700;">
												<a href="{{route('jobCandidate.applyCandidateList',$value->job_id)}}"><i class="icon-briefcase applicatioFontStyle"></i> {{$value->totalApplication}}</a>
											</td>
											<td style="font-size: 14px;font-weight: 700;"><a href="{{route('jobCandidate.shortListedApplicant',$value->job_id)}}"><i class="fa fa-star-o applicatioFontStyle"></i> {{$value->shortList}}</a></td>
											<td style="font-size: 14px;font-weight: 700;"><a href="{{route('jobCandidate.rejectedApplicant',$value->job_id)}}"><i class="fa fa-eraser applicatioFontStyle"></i> {{$value->reject}}</a></td>
											<td style="font-size: 14px;font-weight: 700;"><a href="{{route('jobCandidate.jobInterviewList',$value->job_id)}}"><i class="applicatioFontStyle fa fa-user"></i> {{$value->interview}}</a></td>
										</tr>
									@endforeach
									@else
										<tr>
											<td colspan="6">@lang('common.no_data_available') !</td>
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
