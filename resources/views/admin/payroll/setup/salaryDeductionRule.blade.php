@extends('admin.master')
@section('content')
@section('title')
@lang('payroll_setup.salary_deduction_for_late_attendance')
@endsection
<style>

	.select2{ width: 100% !important;}

</style>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	

		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @lang('payroll_setup.rules_for_salary_deduction') </div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
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
							<div class="table-responsive">
								<table  class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>S/L</th>
											<th>@lang('payroll_setup.for_days')</th>
											<th>@lang('payroll_setup.day_oF_salary_deduction')</th>
											<th>@lang('common.status')</th>
											<th>@lang('common.update')</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<input type="hidden" class="form-control salary_deduction_for_late_attendance_id"  value="{{$data->salary_deduction_for_late_attendance_id}}">
												<input type="number" class="form-control for_days"  value="{{$data->for_days}}" placeholder="For Days EX:(3)">
											</td>
											<td>
												<input type="number" readonly class="form-control day_of_salary_deduction"  value="{{$data->day_of_salary_deduction}}" placeholder="Salary Deduction For Day EX:(1)">
											</td>
											<td>
												<select class="form-control status select2">
													<option value="Active" @if($data->status == "Active") {{"selected"}} @endif>@lang('common.active')</option>
													<option value="Inactive"  @if($data->status == "Inactive") {{"selected"}} @endif>@lang('common.inactive')</option>
												</select>
											</td>
											<td>
												<button type="button" class="btn btn-sm btn-success updateRule">
												@lang('common.update')
												</button>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
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



            $("body").on("click",".updateRule",function(){
                var salary_deduction_for_late_attendance_id  = $('.salary_deduction_for_late_attendance_id').val();
                var for_days      							 = $('.for_days').val();
                var day_of_salary_deduction      			 = $('.day_of_salary_deduction').val();
                var status      							 = $('.status').val();

                var action = "{{ URL::to('salaryDeductionRuleForLateAttendance/updateSalaryDeductionRule') }}";
                $.ajax({
                    type: "post",
                    url: action,
                    data: {'salary_deduction_for_late_attendance_id': salary_deduction_for_late_attendance_id, 'for_days': for_days,'day_of_salary_deduction':day_of_salary_deduction,'status':status,'_token': $('input[name=_token]').val()},
                    success: function (data) {
                        if(data == 'success'){
                            $.toast({
                                heading: 'success',
                                text: 'Salary deduction rule update successfully !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                        }else{
                            $.toast({
                                heading: 'Problem',
                                text: 'Something error found !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 6
                            });
                        }

                    }
                });
			})
		});
	</script>
@endsection
