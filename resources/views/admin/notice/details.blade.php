@extends('admin.master')
@section('content')
@section('title')
   @lang('dashboard.notice_board')

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
				<a href="{{route('notice.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('notice.view_notice') </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="col-lg-offset-2 col-md-8">
								<div class="white-box">
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="mail-contnet">
												<h5>{{$editModeData->title}}</h5>
												@php
													$noticeDate=strtotime($editModeData->publish_date);
												@endphp
												<span class="time">{{date(" d M Y ", $noticeDate)}} ,{{$editModeData->createdBy->first_name}} {{$editModeData->createdBy->last_name}}</span>
												<br>
												<br/><span class="">{!! $editModeData->description !!}</span>

												<br/>
												<br/>
												<br/>
												@php
													if($editModeData->attach_file!='')
													{
														$info  = new SplFileInfo($editModeData->attach_file);
														$extension = $info->getExtension();

														if($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg' || $extension === 'PNG' || $extension === 'JPG' || $extension === 'JPEG'){
															echo '<img src="'.asset('uploads/notice/'.$editModeData->attach_file).'" width="100%" >';
														}else{
															echo '<embed src="'.asset('uploads/notice/'.$editModeData->attach_file).'" width="100%" height="550px" />';
														}
													}
												@endphp

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

