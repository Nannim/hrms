@extends('admin.master')
@section('content')
@section('title')
@if(isset($editModeData))
	
	@lang('allowance.edit_allowance')
@else
@lang('allowance.add_allowance')
@endif
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
				<a href="{{route('allowance.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('allowance.view_allowance') </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('allowance.update', $editModeData->allowance_id), 'method' => 'PUT','files' => 'true','class' => 'form-horizontal','id'=>'allowanceForm')) }}
							@else
								{{ Form::open(array('route' => 'allowance.store','enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'allowanceForm')) }}
							@endif
							
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
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('allowance.allowance_name')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('allowance_name',Input::old('allowance_name'), $attributes = array('class'=>'form-control required allowance_name','id'=>'allowance_name','placeholder'=>__('allowance.allowance_name'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('allowance.allowance_type')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{{ Form::select('allowance_type', array('Percentage' => 'Percentage', 'Fixed' => 'Fixed'), Input::old('allowance_type'), array('class' => 'form-control allowance_type required')) }}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('allowance.percentage_of_basic')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::number('percentage_of_basic',Input::old('percentage_of_basic'), $attributes = array('class'=>'form-control required percentage_of_basic','id'=>'percentage_of_basic','placeholder'=>__('allowance.percentage_of_basic'),'min'=>'0','max'=>'100')) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('allowance.limit_per_month')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::number('limit_per_month',Input::old('limit_per_month'), $attributes = array('class'=>'form-control required limit_per_month','id'=>'limit_per_month','placeholder'=>__('allowance.limit_per_month'),'min'=>'0')) !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-offset-4 col-md-8">
													@if(isset($editModeData))
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-pencil"></i> @lang('common.update')</button>
													@else
														<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
													@endif
												</div>
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
@section('page_scripts')
	<script>
        jQuery(function (){

            $("#allowanceForm").validate();

            $(document).on("change",".allowance_type",function(){
                var allowance_type		 =  $('.allowance_type').val();
                if(allowance_type == 'Fixed'){
                    $('.percentage_of_basic').val('0');
                    $('body').find('.percentage_of_basic').attr('readonly', true);
                }else{
                    $('.percentage_of_basic').val('0');
                    $('body').find('.percentage_of_basic').attr('readonly', false);
                }
            });

			@if(isset($editModeData))
				@if($editModeData->allowance_type == 'Fixed')
				{!! "$('body').find('.percentage_of_basic').attr('readonly', true)" !!}
				@endif
			@endif
        });

	</script>
@endsection

