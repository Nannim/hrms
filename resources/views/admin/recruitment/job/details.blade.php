@extends('admin.master')
@section('content')
@section('title')
@lang('recruitement.description')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
				<a href="{{route('jobPost.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  View Job  </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="col-md-offset-1 col-md-11">
								<div class="white-box">
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="user-img">  </div>
											<div class="">
												<h5 style="font-weight: 700"> {{$result->job_title}}</h5>
												<span class="time">@lang('recruitement.job_post') : {{$result->post}}</span><br>
												<span class="time">@lang('recruitement.publish_by') : @if(isset($result->createdBy->first_name)) {{$result->createdBy->first_name}} {{$result->createdBy->last_name}}@endif </span><br>
												<span class="time">@lang('recruitement.job_publish_date') : {{date(" d M Y", strtotime($result->created_at))}} </span><br>
												<br/><span class="mail-desc">
													{!! $result->job_description !!}
												</span>
											</div>
											<br>
											<div class="test-center">
												<p style="font-weight:400 ">@lang('Application End Date') : {{date(" d M Y ", strtotime($result->application_end_date))}}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

