@extends('admin.master')
@section('content')
@section('title')
@lang('termination.employee_termination_details')
@endsection
<style>
	.post {
		font-weight: 500;
		font-size: 16px;
	}

	.details {
		font-size: 13px;
		color: #98a6ad;
	}
</style>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashobard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<a href="{{route('termination.index')}}" class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('termination.view_termination') </a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
			<p class="box-title post">@yield('title')</p>
			<br>
		</div>
		<div class="col-md-offset-2 col-md-7 ">
			<div class="panel panel-default">
				<div class="panel-heading">{{$result->subject}}</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<span class="details"><i class="fa fa-user"></i>&nbsp;
							@if(isset($result->terminateTo->first_name))
							{{$result->terminateTo->first_name}} {{ $result->terminateTo->last_name}}
							@endif
						</span>&nbsp;
						<span class="details"><i class="fa fa-align-justify"></i>&nbsp;
							@if(isset($result->terminateTo->department->department_name))
							{{$result->terminateTo->department->department_name}}
							@endif
						</span>&nbsp;
						@if($result->status == 1)
						<span class="label label-rouded label-info">PENDING</span>
						@else
						<span class="label label-rouded label-success">APPROVED</span>
						@endif
						<p class="coverLater">{!! $result->description !!}</p>
					</div>
					<div class="panel-footer">
						<p>
							<b>@lang('termination.terminated_by') :</b>@if(isset($result->terminateBy->first_name))
							{{$result->terminateBy->first_name}} {{ $result->terminateBy->last_name}}
							@endif
							<b>@lang('termination.notice_date') :</b>{{date(" d M Y ", strtotime($result->notice_date))}},
							<b>@lang('termination.termination_date') :</b>{{date(" d M Y ", strtotime($result->termination_date))}}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection