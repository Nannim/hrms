@extends('admin.master')
@section('content')
@section('title')
@lang('salary_sheet.Generate Bulk Salary Sheet')
@endsection
<style>
	.table>tbody>tr>td {
		padding: 5px 7px;
	}
	.address{
		margin-top: 22px;
	}
	.employeeName{
		position: relative;
	}
	#employee_id-error{
		position: absolute;
		top: 66px;
		left: 0;
		width: 100%he;
		width: 100%;
		height: 100%;
	}
	.icon-question {
		color: #7460ee;
		font-size: 16px;
		vertical-align: text-bottom;
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
			<a href="{{route('generateSalarySheet.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('salary_sheet.generate_payslip')</a>
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
								&nbsp;<strong>{{ session()->get('error') }}</strong>
							</div>
						@endif
						{{ Form::open(array('route' => 'generateSalarySheet.bulk.result','method'=>'GET','id'=>'calculateEmployeeSalaryForm')) }}
						<div class="form-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label for="exampleInput">@lang('employee.Branch')</label>
                                        <select class="form-control select2" name="branch_id">
                                         <option value="">All Branches</option>
                                         @foreach($branches as $branch)
                                         <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                         @endforeach
                                        </select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label for="exampleInput">@lang('employee.department')</label>
                                        <select class="form-control select2" name="department_id">
                                         <option value="">All Departments</option>
                                         @foreach($departments as $department)
                                         <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                         @endforeach
                                        </select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label for="exampleInput">@lang('employee.designation')</label>
                                        <select class="form-control select2" name="designation_id">
                                         <option value="">All Designation</option>
                                         @foreach($designations as $designation)
                                         <option value="{{ $designation->designation_id }}">{{ $designation->designation_name }}</option>
                                         @endforeach
                                        </select>
									</div>
								</div>
								<div class="col-md-3">
									<label for="exampleInput">@lang('common.month')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										{!! Form::text('month', (isset($month)) ? $month : '', $attributes = array('class'=>'form-control required monthField','id'=>'month','placeholder'=>__('common.month'))) !!}
									</div>
								</div>
								<div class="col-md-4 col-md-offset-4">
									<div class="form-group">
										<button type="submit" class="btn btn-info " style="margin-top: 24px"> @lang('salary_sheet.Generate Bulk Salary Sheet')</button>
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
	<script type="text/javascript">
        jQuery(function(){
            $("#calculateEmployeeSalaryForm").validate();
        });
	</script>
@endsection
