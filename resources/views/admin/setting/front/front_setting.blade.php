@extends('admin.master')
@section('content')

@section('title')
@lang('front.front_end_setting')
@endsection

<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>@lang('dashboard.dashboard')</a></li>
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
						{{ Form::open(array('route' => 'front.setting.submit','enctype'=>'multipart/form-data','class'=>'form-horizontal')) }}
						<div class="form-body">
							<div class="row">
								<div class="col-md-offset-2 col-md-6">
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
								</div>
							</div>
							<div class="row">
								<input type="hidden" value="{{ $setting->id }}" name="id">
								<div class="col-md-4 mt-1" style="margin-top:10px;">

										<label class="control-label">@lang('front.company_name')<span class="validateRq">*</span></label>

										<input type="text" class="form-control" name="company_title" value="{{ $setting->company_title }}" placeholder="{{ __('front.company_name') }}" required>

								</div>
								<div class="col-md-4 mt-1" style="margin-top:10px;">

										<label class="control-label">@lang('front.company_logo')<span class="validateRq">*</span></label>
									   <img src="{{ url('uploads/front/'.$setting->logo) }}" style="max-height: 90px;">
										<input type="file" class="form-control" name="company_logo" value="">

								</div>

								<div class="col-md-4 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.home_page_big_title')<span class="validateRq">*</span></label>

										<input type="text" class="form-control" name="home_page_big_title" placeholder="@lang('front.home_page_big_title')" value="{{ $setting->home_page_big_title }}">
								</div>

								<div class="col-md-12 mt-1" style="margin-top:10px;">

										<label class="control-label">@lang('front.home_page_short_description')<span class="validateRq">*</span></label>
										<textarea class="form-control" placeholder="@lang('front.home_page_short_description')" name="short_description">{{ $setting->short_description }}</textarea>
								</div>


								<div class="col-md-6 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.service_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="service_title" placeholder="@lang('front.service_title')" value="{{ $setting->service_title }}">
								</div>

								<div class="col-md-6 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.job_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="job_title" placeholder="@lang('front.job_title')" value="{{ $setting->job_title }}">
								</div>


                               <!-- counter  -->
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_1_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_1_title" placeholder="@lang('front.counter_1_title')" value="{{ $setting->counter_1_title }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_2_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_2_title" placeholder="@lang('front.counter_2_title')" value="{{ $setting->counter_2_title }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_3_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_3_title" placeholder="@lang('front.counter_3_title')" value="{{ $setting->counter_3_title }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_4_title')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_4_title" placeholder="@lang('front.counter_4_title')" value="{{ $setting->counter_4_title }}">
								</div>

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_1_value')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_1_value" placeholder="@lang('front.counter_1_value')" value="{{ $setting->counter_1_value }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_2_value')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_2_value" placeholder="@lang('front.counter_2_value')" value="{{ $setting->counter_2_value }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_3_value')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_3_value" placeholder="@lang('front.counter_3_value')" value="{{ $setting->counter_3_value }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.counter_4_value')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="counter_4_value" placeholder="@lang('front.counter_4_value')" value="{{ $setting->counter_4_value }}">
								</div>

								<!-- about us  -->

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.about_us_image') (800X800)<span class="validateRq">*</span></label>
										<img src="{{ url('uploads/front/'.$setting->about_us_image) }}" style="max-height: 200px;">
										<input type="file" class="form-control" name="about_us_image" placeholder="@lang('front.about_us_image')">
								</div>

								<div class="col-md-9 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.about_us_description')<span class="validateRq">*</span></label>
										<textarea style="min-height: 200px;" class="form-control" placeholder="@lang('front.about_us_description')" name="about_us_description">{!! $setting->about_us_description !!}</textarea>
								</div>

                                 <!-- contact  -->
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.contact_website')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="contact_website" placeholder="@lang('front.contact_website')" value="{{ $setting->contact_website }}">
								</div>

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.contact_email')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="contact_email" placeholder="@lang('front.contact_email')" value="{{ $setting->contact_email }}">
								</div>

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.contact_phone')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="contact_phone" placeholder="@lang('front.contact_phone')" value="{{ $setting->contact_phone }}">
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.contact_address')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="contact_address" placeholder="@lang('front.contact_address')" value="{{ $setting->contact_address }}">
								</div>

                                 <!-- flug show   -->
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.show_job_section')<span class="validateRq">*</span></label>
										<select type="text" class="form-control" name="show_job" placeholder="@lang('front.show_job_section')" >
											<option @if($setting->show_job == 1) selected @endif   value="1">Yes</option>
											<option @if($setting->show_job == 0) selected @endif  value="0">No</option>
										</select>
								</div>

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.show_service_section')<span class="validateRq">*</span></label>
										<select type="text" class="form-control" name="show_service" placeholder="@lang('front.show_service_section')">
											<option @if($setting->show_service == 1) selected @endif value="1">Yes</option>
											<option @if($setting->show_service == 0) selected @endif value="0">No</option>
										</select>
								</div>

								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.show_about_section')<span class="validateRq">*</span></label>
										<select type="text" class="form-control" name="show_about" placeholder="@lang('front.show_about_section')" >
											<option @if($setting->show_about == 1) selected @endif value="1">Yes</option>
											<option @if($setting->show_about == 0) selected @endif value="0">No</option>
										</select>
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.show_contact_section')<span class="validateRq">*</span></label>
										<select type="text" class="form-control" name="show_contact" placeholder="@lang('front.show_contact_section')" >
											<option @if($setting->show_contact == 1 ) selected @endif value="1">Yes</option>
											<option @if($setting->show_contact == 0) selected @endif value="0">No</option>
										</select>
								</div>
								<div class="col-md-3 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.show_counter_section')<span class="validateRq">*</span></label>
										<select type="text" class="form-control" name="show_counter" placeholder="@lang('front.show_counter_section')" >
											<option @if($setting->show_counter == 1) selected @endif value="1">Yes</option>
											<option @if($setting->show_counter == 0) selected @endif value="0">No</option>
										</select>
								</div>

								<div class="col-md-6 mt-1" style="margin-top:10px;">
										<label class="control-label">@lang('front.footer_text')<span class="validateRq">*</span></label>
										<input type="text" class="form-control" name="footer_text" placeholder="@lang('front.footer_text')" value="{{ $setting->footer_text }}"  />
								</div>



							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-8" style="margin-top:20px;">
											<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i>@lang('common.update')</button>
									</div>
								</div>
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
