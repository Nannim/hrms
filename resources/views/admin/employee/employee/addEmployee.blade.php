@extends('admin.master')
@section('content')
@section('title')
@lang('employee.add_employee')
@endsection
<style>
	.appendBtnColor{
		color: #fff;
		font-weight: 700;
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
				<a href="{{route('employee.index')}}"
				 class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>
				   @lang('employee.view_employee')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
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
							{{ Form::open(array('route' => 'employee.store','enctype'=>'multipart/form-data','id'=>'employeeForm')) }}
								<div class="form-body">
									<h3 class="box-title">@lang('employee.employee_account')</h3>
									<hr>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">@lang('employee.role')<span class="validateRq">*</span></label>
												<select name="role_id" class="form-control user_id required select2" required>
													<option value="">--- @lang('common.please_select') ---</option>
													@foreach($roleList as $value)
														<option value="{{$value->role_id}}" @if($value->role_id == old('role_id')) {{"selected"}} @endif>{{$value->role_name}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<label for="exampleInput">@lang('employee.user_name')<span class="validateRq">*</span></label>
											<div class="input-group">
												<div class="input-group-addon"><i class="ti-user"></i></div>
												<input class="form-control required user_name" required id="user_name" placeholder="@lang('employee.user_name')" name="user_name" type="text" value="{{ old('user_name') }}">
											</div>
										</div>
										<div class="col-md-3">
											<label for="password">@lang('employee.password')<span class="validateRq">*</span></label>
											<div class="input-group">
												<div class="input-group-addon"><i class="ti-lock"></i></div>
												<input class="form-control required password" required id="password" placeholder="@lang('employee.password')" name="password" type="password">
											</div>
										</div>
										<div class="col-md-3">
											<label for="password_confirmation">@lang('employee.confirm_password')<span class="validateRq">*</span></label>
											<div class="input-group">
												<div class="input-group-addon"><i class="ti-lock"></i></div>
												<input class="form-control required password_confirmation" required id="password_confirmation" placeholder="@lang('employee.confirm_password')" name="password_confirmation" type="password">
											</div>
										</div>
									</div>
									<h3 class="box-title">@lang('employee.personal_information')</h3>
									<hr>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">@lang('employee.first_name')<span class="validateRq">*</span></label>
												<input class="form-control required first_name" required id="first_name" placeholder="@lang('employee.first_name')" name="first_name" type="text" value="{{ old('first_name') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">@lang('employee.last_name')</label>
												<input class="form-control last_name" id="last_name" placeholder="@lang('employee.last_name')" name="last_name" type="text" value="{{ old('last_name') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">@lang('employee.finger_print_no')<span class="validateRq">*</span></label>
												<input class="form-control number finger_id" required  id="finger_id" placeholder="@lang('employee.finger_print_no')" name="finger_id" type="text" value="{{ old('finger_id') }}">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">@lang('employee.supervisor')</label>
												<select name="supervisor_id" class="form-control supervisor_id required select2" >
													<option value="">--- @lang('common.please_select') ---</option>
													@foreach($supervisorList as $value)
														<option value="{{$value->employee_id}}" @if($value->employee_id == old('employee_id')) {{"selected"}} @endif>{{$value->first_name}} {{$value->last_name}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('department.department_name')<span class="validateRq">*</span></label>
										<select name="department_id" class="form-control department_id  select2" required>
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($departmentList as $value)
												<option value="{{$value->department_id}}" @if($value->department_id == old('department_id')) {{"selected"}} @endif>{{$value->department_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('designation.designation_name')<span class="validateRq">*</span></label>
										<select name="designation_id" class="form-control department_id select2" required>
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($designationList as $value)
												<option value="{{$value->designation_id}}" @if($value->designation_id == old('designation_id')) {{"selected"}} @endif>{{$value->designation_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('branch.branch_name')</label>
										<select name="branch_id" class="form-control branch_id select2">
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($branchList as $value)
												<option value="{{$value->branch_id}}" @if($value->branch_id == old('branch_id')) {{"selected"}} @endif>{{$value->branch_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('work_shift.work_shift_name')<span class="validateRq">*</span></label>
										<select name="work_shift_id" class="form-control work_shift_id select2" required>
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($workShiftList as $value)
												<option value="{{$value->work_shift_id}}" @if($value->work_shift_id == old('work_shift_id')) {{"selected"}} @endif>{{$value->shift_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.montly_paygrade')<span class="validateRq">*</span></label>
										<select name="pay_grade_id" class="form-control pay_grade_id required" required>
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($payGradeList as $value)
												<option value="{{$value->pay_grade_id}}" @if($value->pay_grade_id == old('pay_grade_id')) {{"selected"}} @endif>{{$value->pay_grade_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.hourly_paygrade')<span class="validateRq">*</span></label>
										<select name="hourly_salaries_id" class="form-control hourly_pay_grade_id required" required>
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach($hourlyPayGradeList as $value)
												<option value="{{$value->hourly_salaries_id}}" @if($value->hourly_salaries_id == old('hourly_salaries_id')) {{"selected"}} @endif>{{$value->hourly_grade}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.email')</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input class="form-control email" id="email" placeholder="@lang('employee.email')" name="email" type="email" value="{{ old('email') }}">
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.phone')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
										<input class="form-control number phone" id="phone" required placeholder="@lang('employee.phone')"  name="phone" type="number" value="{{ old('phone') }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.gender')<span class="validateRq">*</span></label>
										<select name="gender" class="form-control gender select2" required>
											<option value="">--- @lang('common.please_select') ---</option>
											<option value="Male" @if('Male' == old('gender')) {{"selected"}} @endif>@lang('employee.male')</option>
											<option value="Female" @if('Female' == old('gender')) {{"selected"}} @endif>@lang('employee.female')</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.religion')</label>
										<input class="form-control religion" id="religion" placeholder="@lang('employee.religion')" name="religion" type="text" value="{{ old('religion') }}">
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.date_of_birth')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input class="form-control date_of_birth dateField" readonly required  id="date_of_birth" placeholder="@lang('employee.date_of_birth')" name="date_of_birth" type="text" value="{{ old('date_of_birth') }}">
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.date_of_joining')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input class="form-control date_of_joining dateField" readonly required id="date_of_joining" placeholder="@lang('employee.date_of_joining')" name="date_of_joining" type="text" value="{{ old('date_of_joining') }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.date_of_leaving')</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input class="form-control  date_of_leaving dateField" readonly id="date_of_leaving" placeholder="@lang('employee.date_of_leaving')" name="date_of_leaving" type="text" value="{{ old('date_of_leaving') }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.marital_status')</label>
										<select name="marital_status" class="form-control status required select2" >
											<option value="">--- @lang('common.please_select') ---</option>
											<option value="Unmarried" @if('Unmarried' == old('marital_status')) {{"selected"}} @endif>@lang('employee.unmarried')</option>
											<option value="Married" @if('Married' == old('marital_status')) {{"selected"}} @endif>@lang('employee.married')</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('common.status')<span class="validateRq">*</span></label>
										<select name="status" class="form-control status select2" required>
											<option value="1" @if('1' == old('status')) {{"selected"}} @endif>@lang('common.active')</option>
											<option value="2" @if('2' == old('status')) {{"selected"}} @endif>@lang('common.inactive')</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('employee.photo')</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="	fa fa-picture-o"></i></span>
										<input class="form-control photo" id="photo" accept="image/png, image/jpeg, image/gif,image/jpg"  name="photo" type="file">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.address')</label>
										<textarea class="form-control address" id="address" placeholder="@lang('employee.address')" cols="30" rows="2" name="address">{{ old('address') }}</textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.emergency_contact')</label>
										<textarea class="form-control emergency_contacts" id="emergency_contacts" placeholder="@lang('employee.emergency_contact')" cols="30" rows="2" name="emergency_contacts">{{ old('emergency_contacts') }}</textarea>
									</div>
								</div>
							</div>
							<br>
								<h3 class="box-title">@lang('employee.educational_qualification')</h3>
									<hr>
									<div class="education_qualification_append_div">

									</div>
									<div class="row">
										<div class="col-md-9"></div>
										<div class="col-md-3"><div class="form-group">
										<input id="addEducationQualification" type="button" class="form-control btn btn-success appendBtnColor"
										 value="@lang('employee.add_educational_qualification')"></div></div>
									</div>
								</div>

								<h3 class="box-title">@lang('employee.professional_experience')</h3>
									<hr>
									<div class="experience_append_div">

									</div>
									<div class="row">
										<div class="col-md-9"></div>
										<div class="col-md-3"><div class="form-group"><input id="addExperience" type="button"
										 class="form-control btn btn-success appendBtnColor"  value="@lang('employee.add_professional_experience')"></div></div>
									</div>
									<div class="form-actions">
									<div class="row">
										<div class="col-md-12 ">
											<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
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

	<div class="row_element1" style="display: none;">
	<input name="educationQualification_cid[]" type="hidden">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.institute')<span class="validateRq">*</span></label>
				<select name="institute[]" class="form-control institute">
					<option value="">--- @lang('common.please_select') ---</option>
					<option value="Board">@lang('employee.board')</option>
					<option value="University">@lang('employee.university')</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.board') / @lang('employee.university')<span class="validateRq">*</span></label>
				<input type="text" name="board_university[]" class="form-control board_university" id="board_university" placeholder="@lang('employee.board') / @lang('employee.university')">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.degree')<span class="validateRq">*</span></label>
				<input type="text" name="degree[]" class="form-control degree required" id="degree" placeholder="Example: B.Sc. Engr.(Bachelor of Science in Engineering)">
			</div>
		</div>
		<div class="col-md-3">
			<label for="exampleInput">@lang('employee.passing_year')<span class="validateRq">*</span></label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
				<input type="text" name="passing_year[]" class="form-control yearPicker required" id="passing_year" placeholder="@lang('employee.passing_year')">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.result')</label>
				<select name="result[]" class="form-control result">
					<option value="">--- @lang('common.please_select') ---</option>
					<option value="First class">First class</option>
					<option value="Second class">Second class</option>
					<option value="Third class">Third class</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.gpa') / @lang('employee.cgpa')</label>
				<input type="text" name="cgpa[]" class="form-control cgpa" id="cgpa" placeholder="Example: 5.00,4.63">
			</div>
		</div>
		<div class="col-md-3"></div>
		<div class="col-md-3">
			<div class="form-group">
				<input  type="button" class="form-control btn btn-danger deleteEducationQualification appendBtnColor" style="margin-top: 17px" value="@lang('common.delete')">
			</div>
		</div>
	</div>
	<hr>
</div>

<div class="row_element2" style="display: none;">
	<input name="employeeExperience_cid[]" type="hidden">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.organization_name')<span class="validateRq">*</span></label>
				<input type="text" name="organization_name[]" class="form-control organization_name" id="organization_name" placeholder="@lang('employee.organization_name')">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.designation')<span class="validateRq">*</span></label>
				<input type="text" name="designation[]" class="form-control designation" id="designation" placeholder="@lang('employee.designation')">
			</div>
		</div>
		<div class="col-md-3">
			<label for="exampleInput">@lang('common.from_date')<span class="validateRq">*</span></label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" name="from_date[]" class="form-control dateField" id="from_date" placeholder="@lang('common.from_date')">
			</div>
		</div>
		<div class="col-md-3">
			<label for="exampleInput">@lang('common.to_date')<span class="validateRq">*</span></label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" name="to_date[]" class="form-control dateField" id="to_date" placeholder="@lang('common.to_date')">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.responsibility')<span class="validateRq">*</span></label>
				<textarea name="responsibility[]" class="form-control responsibility" placeholder="@lang('employee.responsibility')" cols="30" rows="2"></textarea>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="exampleInput">@lang('employee.skill')<span class="validateRq">*</span></label>
				<textarea name="skill[]" class="form-control skill" placeholder="@lang('employee.skill')" cols="30" rows="2"></textarea>
			</div>
		</div>
		<div class="col-md-3"></div>
		<div class="col-md-3">
			<div class="form-group">
				<input  type="button" class="form-control btn btn-danger deleteExperience appendBtnColor" style="margin-top: 17px" value="@lang('common.delete')">
			</div>
		</div>
	</div>
	<hr>
</div>
@endsection
@section('page_scripts')
	<script>
        $(document).ready(function (){

            $('#addEducationQualification').click(function(){
                $('.education_qualification_append_div').append('<div class="education_qualification_row_element">' + $('.row_element1').html() + '</div>');
            });

            $('#addExperience').click(function(){
                $('.experience_append_div').append('<div class="experience_row_element">' + $('.row_element2').html() + '</div>');
            });

            $(document).on("click",".deleteEducationQualification",function(){
                $(this).parents('.education_qualification_row_element').remove();
                var deletedID = $(this).parents('.education_qualification_row_element').find('.educationQualification_cid').val();
                if (deletedID) {
                    var prevDelId = $('#delete_education_qualifications_cid').val();
                    if (prevDelId) {
                        $('#delete_education_qualifications_cid').val(prevDelId + ',' + deletedID);
                    } else {
                        $('#delete_education_qualifications_cid').val(deletedID);
                    }
                }
            });

            $(document).on("click",".deleteExperience",function(){
                $(this).parents('.experience_row_element').remove();
                var deletedID = $(this).parents('.experience_row_element').find('.employee_experience_id').val();
                if (deletedID) {
                    var prevDelId = $('#delete_experiences_cid').val();
                    if (prevDelId) {
                        $('#delete_experiences_cid').val(prevDelId + ',' + deletedID);
                    } else {
                        $('#delete_experiences_cid').val(deletedID);
                    }
                }
            });

            $(document).on('change','.pay_grade_id',function(){
                var data = $('.pay_grade_id').val();
                if(data){
                     $('.hourly_pay_grade_id').val('');
                     $('.pay_grade_id').attr('required',false);
                     $('.hourly_pay_grade_id').attr('required',false);
				}else{
                    $('.pay_grade_id').attr('required',true);
                    $('.hourly_pay_grade_id').attr('required',true);
                }
            });

            $(document).on('change','.hourly_pay_grade_id',function(){
               var data = $('.hourly_pay_grade_id').val();
               if(data){
                    $('.pay_grade_id').val('');
                   $('.pay_grade_id').attr('required',false);
                   $('.hourly_pay_grade_id').attr('required',false);
			   }else{
                   $('.pay_grade_id').attr('required',true);
                   $('.hourly_pay_grade_id').attr('required',true);
               }
            });

        });

	</script>
@endsection
