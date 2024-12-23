@extends('admin.master')
@section('content')
@section('title')
@lang('setting.general_settings')
@endsection
<link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/html5-editor/bootstrap-wysihtml5.css')!!}" />
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		   <ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">

						<div class="form-body">
							<section class="m-t-40">
								<div class="sttabs tabs-style-iconbox">
									<nav>
										<ul>
											<li><a href="#section-iconbox-1" class="sticon ti-settings"><span>@lang('setting.company_addrees_settings')</span></a></li>
											<li><a href="#section-iconbox-2" class="sticon ti-settings"><span>@lang('setting.print_head_settings')</span></a></li>
									<!-- 		<li><a href="#section-iconbox-2" class="sticon ti-settings"><span>Settings</span></a></li>
											<li><a href="#section-iconbox-4" class="sticon ti-settings"><span>Settings</span></a></li> -->
										</ul>
									</nav>
									<div class="content-wrap">
										<section id="section-iconbox-1">
											@if($data)
												{{ Form::open(array('route' => array('generalSettings.update', $data->company_address_setting_id), 'method' => 'PUT','files' => 'true','id' => 'companyAddressForm','class' => 'form-horizontal')) }}
											@else
												{{ Form::open(array('route' => 'generalSettings.store','enctype'=>'multipart/form-data','id'=>'companyAddressForm','class' => 'form-horizontal')) }}
											@endif
												@if($errors->any())
													<div class="alert alert-danger alert-dismissible" role="alert">
														<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
														@foreach($errors->all() as $error)
															<strong>{!! $error !!}</strong><br>
														@endforeach
													</div>
												@endif
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
												<div class="form-group">
													<textarea class="textarea_editor form-control" rows="8" name="address" placeholder="Enter text ...">@if($data) {{ $data->address }} @else {{old('address')}}@endif</textarea>
													@if ($errors->has('address'))
														<span class="help-block">
															<strong style="color: red">{{ $errors->first('address') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-actions">
													<div class="row">
														<div class="col-md-12 text-center">

															<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @if($data) @lang('common.update') @else @lang('common.save') @endif</button>
														</div>
													</div>
												</div>
											{{ Form::close() }}
										</section>
										<section id="section-iconbox-2">
											@if($printHeadData)
												{{ Form::open(array('route' => array('printHeadSettings.update', $printHeadData->print_head_setting_id), 'method' => 'PUT','files' => 'true','id' => 'printHeadSettingsForm','class' => 'form-horizontal')) }}
											@else
												{{ Form::open(array('route' => 'printHeadSettings.store','enctype'=>'multipart/form-data','id'=>'printHeadSettings','class' => 'form-horizontal')) }}
											@endif
											@if($errors->any())
												<div class="alert alert-danger alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
													@foreach($errors->all() as $error)
														<strong>{!! $error !!}</strong><br>
													@endforeach
												</div>
											@endif
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
											<div class="form-group">
												<textarea class="textarea_editor2 form-control" rows="20" name="description" placeholder="Enter text ...">@if($printHeadData) {{ $printHeadData->description }} @else {{old('description')}}@endif</textarea>
												@if ($errors->has('description'))
													<span class="help-block">
															<strong style="color: red">{{ $errors->first('description') }}</strong>
														</span>
												@endif
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-12 text-center">

														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @if($printHeadData) @lang('common.update') @else @lang('common.save') @endif</button>
													</div>
												</div>
											</div>
											{{ Form::close() }}
										</section>
										<!-- <section id="section-iconbox-3">
											<h2>......................</h2></section>
										<section id="section-iconbox-4">
											<h2>......................</h2></section>
										<section id="section-iconbox-5">
											<h2>......................</h2></section> -->
									</div>
									<!-- /content -->
								</div>
								<!-- /tabs -->
							</section>

						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('page_scripts')
	<script src="{!! asset('admin_assets/js/cbpFWTabs.js')!!}"></script>
	<script src="{!! asset('admin_assets/plugins/bower_components/html5-editor/wysihtml5-0.3.0.js')!!}"></script>
	<script src="{!! asset('admin_assets/plugins/bower_components/html5-editor/bootstrap-wysihtml5.js')!!}"></script>

	<script type="text/javascript">
        (function() {
            $('.textarea_editor').wysihtml5();
            $('.textarea_editor2').wysihtml5();

            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                new CBPFWTabs(el);
            });
        })();
	</script>
@endsection
