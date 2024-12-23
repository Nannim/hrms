@extends('admin.master')
@section('content')
@section('title')
@lang('warning.warning')
@endsection
<style>
	.post {
		font-weight: 500;
		font-size: 16px;
	}
	.details{
		font-size: 13px;
		color: #98a6ad;
	}
</style>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{route('warning.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('warning.view_warning')  </a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-offset-2 col-md-7">
				<p class="box-title post" >@lang('warning.warning') @lang('warning.description')</p>
				<br>
			</div>
			<div class="col-md-offset-2 col-md-7 ">
				<div class="panel panel-default">
					<div class="panel-heading">{{$result->subject}}</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<span class="details"><i class="fa fa-user"></i>&nbsp;
								@if(isset($result->warningTo->first_name))
									{{$result->warningTo->first_name}} {{ $result->warningTo->last_name}}
								@endif
							</span>&nbsp;
							<span class="details"><i class="fa fa-align-justify"></i>&nbsp;
								@if(isset($result->warningTo->department->department_name))
									{{$result->warningTo->department->department_name}}
								@endif
							</span>&nbsp;
							<p class="coverLater">{!! $result->description !!}</p>
						</div>
						<div class="panel-footer">
							<p>
								<b>@lang('warning.warning_by') :</b>@if(isset($result->warningBy->first_name))
									{{$result->warningBy->first_name}} {{ $result->warningBy->last_name}}
								@endif,
								<b>@lang('warning.warning_date') :</b>{{date(" d M Y ", strtotime($result->warning_date))}}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

