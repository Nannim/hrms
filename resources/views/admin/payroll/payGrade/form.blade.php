@extends('admin.master')
@section('content')

@section('title')
@if(isset($editModeData))
@lang('paygrade.edit_pay_grade')
@else
@lang('paygrade.add_pay_grade')
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
			<a href="{{route('payGrade.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('paygrade.view_pay_grade') </a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						@if(isset($editModeData))
							{{ Form::model($editModeData, array('route' => array('payGrade.update', $editModeData->pay_grade_id), 'method' => 'PUT','files' => 'true')) }}
						@else
							{{ Form::open(array('route' => 'payGrade.store','enctype'=>'multipart/form-data','id'=>'payGradeForm')) }}
						@endif

						<div class="form-body">

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

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.pay_grade_name')<span class="validateRq">*</span></label>
										{!! Form::text('pay_grade_name',Input::old('pay_grade_name'), $attributes = array('class'=>'form-control required pay_grade_name','id'=>'pay_grade_name','placeholder'=>__('paygrade.pay_grade_name'))) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.gross_salary')<span class="validateRq">*</span></label>
										{!! Form::number('gross_salary',Input::old('gross_salary'), $attributes = array('class'=>'form-control required gross_salary','id'=>'gross_salary','placeholder'=>__('paygrade.gross_salary'),'min'=>'0')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.percentage_of_basic')<span class="validateRq">*</span></label>
										<select class="form-control percentage_of_basic select2  required" name="percentage_of_basic">
                                            <?php
												for($i=5;$i<=100;$i+=5){
													$selected = '';
													if(isset($editModeData)){
														if($editModeData->percentage_of_basic == $i){
															$selected = 'selected';
														}
													}else{
													    if($i==50){
                                                            $selected = 'selected';
														}
													}
													echo '<option value="'.$i.'" '.$selected.'>'.$i.'%</option>';
												}
                                            ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.basic_salary')<span class="validateRq">*</span></label>
										{!! Form::number('basic_salary',Input::old('basic_salary'), $attributes = array('class'=>'form-control required basic_salary','readonly'=>'readonly','id'=>'basic_salary','placeholder'=>__('paygrade.basic_salary'),'min'=>'0')) !!}
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.allowance')<span class="validateRq">*</span></label>
										<table border="1" style="border: 1px solid #ddd;" class="table">
											<thead  class="thead-bar">
											<tr>
												<th>
													<div class="checkbox checkbox-info">
														<input class="inputCheckbox checkAllAllowance"  type="checkbox" id="inlineCheckbox" checked>
														<label>@lang('role.select_all')</label>
													</div>
												</th>
											</tr>
											</thead>
											<tbody>

											@foreach($allowances as $key => $allowance)
												<tr>
													<td>
														<div class="checkbox checkbox-info">
															@if(isset($sortedPayGradeWiseAllowanceData))
																<?php
                                                                	$ifStoredInAllowance = array_search($allowance->allowance_id, array_column($sortedPayGradeWiseAllowanceData, 'allowance_id'));
                                                                ?>
																@if(gettype($ifStoredInAllowance) == 'integer')
																	<input class="allowanceInputCheckbox"  type="checkbox" id="inlineCheckboxAllowance{{$key}}" checked name="allowance_id[]" value="{{$allowance->allowance_id}}">
																	<label for="inlineCheckboxAllowance{{$key}}">{{$allowance->allowance_name}}</label>
																@else
																	<input class="allowanceInputCheckbox"  type="checkbox" id="inlineCheckboxAllowance{{$key}}"  name="allowance_id[]" value="{{$allowance->allowance_id}}">
																	<label for="inlineCheckboxAllowance{{$key}}">{{$allowance->allowance_name}}</label>
																@endif
															@else
																<input class="allowanceInputCheckbox"  type="checkbox" id="inlineCheckboxAllowance{{$key}}" checked name="allowance_id[]" value="{{$allowance->allowance_id}}">
																<label for="inlineCheckboxAllowance{{$key}}">{{$allowance->allowance_name}}</label>
															@endif
														</div>

													</td>
												</tr>
											@endforeach

										</table>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.deduction')<span class="validateRq">*</span></label>
										<table border="1" style="border: 1px solid #ddd;" class="table">
											<thead  class="thead-bar">
											<tr>
												<th >
													<div class="checkbox checkbox-info">
														<input class="inputCheckbox checkAllDeduction"  type="checkbox" id="inlineCheckbox" checked>
														<label >@lang('role.select_all')</label>
													</div>
												</th>
											</tr>
											</thead>
											<tbody>
											@foreach($deductions as $key => $deduction)
												<tr>
													<td>
														@if(isset($sortedPayGradeWiseDeductionData))
                                                            <?php
                                                            	$ifStoredInDeduction = array_search($deduction->deduction_id, array_column($sortedPayGradeWiseDeductionData, 'deduction_id'));
                                                            ?>
															@if(gettype($ifStoredInDeduction) == 'integer')
																	<div class="checkbox checkbox-info">
																		<input class="deductionInputCheckbox"  type="checkbox" id="inlineCheckboxDeductions{{$key}}" checked name="deduction_id[]" value="{{$deduction->deduction_id}}">
																		<label for="inlineCheckboxDeductions{{$key}}">{{$deduction->deduction_name}}</label>
																	</div>
															@else
																	<div class="checkbox checkbox-info">
																		<input class="deductionInputCheckbox"  type="checkbox" id="inlineCheckboxDeductions{{$key}}"  name="deduction_id[]" value="{{$deduction->deduction_id}}">
																		<label for="inlineCheckboxDeductions{{$key}}">{{$deduction->deduction_name}}</label>
																	</div>
															@endif
														@else
															<div class="checkbox checkbox-info">
																<input class="deductionInputCheckbox"  type="checkbox" id="inlineCheckboxDeductions{{$key}}" checked name="deduction_id[]" value="{{$deduction->deduction_id}}">
																<label for="inlineCheckboxDeductions{{$key}}">{{$deduction->deduction_name}}</label>
															</div>
														@endif

													</td>
												</tr>
											@endforeach
										</table>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('paygrade.over_time_rate') (@lang('paygrade.per_hour'))</label>
										{!! Form::number('overtime_rate',Input::old('overtime_rate'), $attributes = array('class'=>'form-control overtime_rate','id'=>'overtime_rate','placeholder'=>__('paygrade.over_time_rate'),'min'=>'0')) !!}
									</div>
								</div>

							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									@if(isset($editModeData))
										<button type="submit" class="btn btn-info btn_style"><i class="fa fa-pencil"></i> @lang('common.update')</button>
									@else
										<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
									@endif
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

            $("#payGradeForm").validate();

            $(document).on("change",".gross_salary,.percentage_of_basic  ",function(){
                var gross_salary		 =  $('.gross_salary').val();
                var percentage_of_basic  =  $('.percentage_of_basic').val();
                var basicSalary = 0;
                basicSalary = (gross_salary * percentage_of_basic) /100;
                $('.basic_salary').val(basicSalary);
            });

            $(document).on("click", '.checkAllAllowance', function (event) {
                if (this.checked) {
                    $('.allowanceInputCheckbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.allowanceInputCheckbox').each(function () {
                        this.checked = false;
                    });
                }
            });

            $(document).on("click", '.checkAllDeduction', function (event) {
                if (this.checked) {
                    $('.deductionInputCheckbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.deductionInputCheckbox').each(function () {
                        this.checked = false;
                    });
                }
            });

        });

	</script>
@endsection

