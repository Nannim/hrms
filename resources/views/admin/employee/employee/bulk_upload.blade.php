@extends('admin.master')
@section('content')
@section('title')
@lang('employee.Bulk Upload')
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
				<a href="{{route('employee.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('employee.view_employee')</a>
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
							{{ Form::open(array('route' => 'store.bulk','enctype'=>'multipart/form-data','id'=>'employeeForm')) }}
								<div class="form-body">
									<h3 class="box-title">@lang('employee.employee_account') </h3>
									<hr>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('employee.CSV file') <a href="{{ url('/sample/sample.csv') }}" >Download Sample</a></label>
										<input type="file" class="form-control" name="upload_file" id="address" placeholder="@lang('employee.CSV file')" >
									</div>
									<div class="form-group">
											<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('employee.Upload')</button>
										</div>
								</div>

								<div class="col-md-9">
									<div class="table-responsive">
										<label class="text-center">Field Evaulation</label>
										<table class="table table-striped">
											<tr >
                                              <th>Field Name</th>
                                              <th>Required</th>
                                              <th>Value</th>
                                              <th>Default</th>
											</tr>
											<tr>
                                              <td>role_id <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any integer and valid role id form role list</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>user_name <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>unique user name</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>password <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any string or integer</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>first_name <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any name as string</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>last_name</td>
                                              <td>No</td>
                                              <td>any last name as string and it's optional</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>finger_id <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>Must be an integer and have to be unique</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>department_id <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any valid department id from department list</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>designation_id <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any valid Designattion id from Designation list</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>branch_id <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>any valid Branch id from Branch list</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>supervisor_id</td>
                                              <td>No</td>
                                              <td>optional and if you provide have to give any previous Employee Id as supervisor</td>
                                              <td>Null</td>
											</tr>
											<tr>
                                              <td>workshitf_id <span class="text-danger">*</span></td>
                                              <td>No</td>
                                              <td>Workshift id from worshift list</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>pay_grade_id</td>
                                              <td>Required when employee is not hourly based</td>
                                              <td>Monthly paygrade id from paygrade list</td>
                                              <td>0</td>
											</tr>
											<tr>
                                              <td>houlry_salries_id</td>
                                              <td>Required when employee is not monthly based</td>
                                              <td>Hourly paygrade id from hourly paygrade list</td>
                                              <td>0</td>
											</tr>
											<tr>
                                              <td>email</td>
                                              <td>No</td>
                                              <td>optional if you provide you have to provide unique and valid email address</td>
                                              <td>NULL</td>
											</tr>
											<tr>
                                              <td>date_of_birth <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>Date Formmat yyyy-mm-dd as example 1990-01-05</td>
                                              <td>N/A</td>
											</tr>
											<tr>
                                              <td>date_of_joining</td>
                                              <td>No</td>
                                              <td>Date Formmat yyyy-mm-dd as example 2020-01-05</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>date_of_leaving</td>
                                              <td>No</td>
                                              <td>Date Formmat yyyy-mm-dd as example 2020-01-05 (optinal applicable for ex employee)</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>marital_status</td>
                                              <td>No</td>
                                              <td>optional will be Married or Unmarried as value</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>address</td>
                                              <td>No</td>
                                              <td>optional any valid text</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>emergency_contacts</td>
                                              <td>No</td>
                                              <td>optional any valid text</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>gender <span class="text-danger">*</span></td>
                                              <td>Yes</td>
                                              <td>string as Male or Female</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>religion</td>
                                              <td>No</td>
                                              <td>Optinal Any String as islam buddism christian</td>
                                              <td>NUll</td>
											</tr>
											<tr>
                                              <td>phone</td>
                                              <td>No</td>
                                              <td>optinal if given have to be Any valid phone number and must be unique for every user </td>
                                              <td>NUll</td>
											</tr>
										</table>
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

@endsection
