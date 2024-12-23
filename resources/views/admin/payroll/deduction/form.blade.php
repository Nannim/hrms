@extends('admin.master')
@section('content')
@section('title')

@if(isset($editModeData))

@lang('deduction.edit_deduction')
@else
@lang('deduction.add_deduction')
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
				<a href="{{route('deduction.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('deduction.view_deduction') </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('deduction.update', $editModeData->deduction_id), 'method' => 'PUT','files' => 'true','class' => 'form-horizontal','id'=>'deductionForm')) }}
							@else
								{{ Form::open(array('route' => 'deduction.store','enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'deductionForm')) }}
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
												<label class="control-label col-md-4">@lang('deduction.deduction_name')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('deduction_name',Input::old('deduction_name'), $attributes = array('class'=>'form-control required deduction_name','id'=>'deduction_name','placeholder'=>__('deduction.deduction_name'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('deduction.deduction_type')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{{ Form::select('deduction_type', array('Percentage' => 'Percentage', 'Fixed' => 'Fixed'), Input::old('deduction_type'), array('class' => 'form-control deduction_type required')) }}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('deduction.percentage_of_basic')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::number('percentage_of_basic',Input::old('percentage_of_basic'), $attributes = array('class'=>'form-control required percentage_of_basic','id'=>'percentage_of_basic','placeholder'=>__('deduction.percentage_of_basic'),'min'=>'0','max'=>'100')) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">@lang('deduction.limit_per_month')<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::number('limit_per_month',Input::old('limit_per_month'), $attributes = array('class'=>'form-control required limit_per_month','id'=>'limit','placeholder'=>__('deduction.limit_per_month'),'min'=>'0')) !!}
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
            $("#deductionForm").validate();

            $(document).on("change",".deduction_type",function(){
                var deduction_type		 =  $('.deduction_type').val();
                if(deduction_type == 'Fixed'){
                    $('.percentage_of_basic').val('0');
                    $('body').find('.percentage_of_basic').attr('readonly', true);
                }else{
                    $('.percentage_of_basic').val('0');
                    $('body').find('.percentage_of_basic').attr('readonly', false);
                }

            });

			@if(isset($editModeData))
				@if($editModeData->deduction_type == 'Fixed')
				{!! "$('body').find('.percentage_of_basic').attr('readonly', true)" !!}
				@endif
			@endif

        });
	</script>
@endsection


