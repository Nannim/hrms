@extends('admin.master')
@section('content')
@section('title','Payment History')
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	

		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>All Payment History</div>
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
								<table  id="myTable" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>S/L</th>
											<th>Month</th>
											<th>Photo</th>
											<th>Employee Name</th>
											<th>Pay Grade</th>
											<th>Basic Salary</th>
											<th>Gross Salary</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if(count($results)>0)
											{!! $sl=null !!}
											@foreach($results AS $value)
												<tr>
													<td style="width: 100px;">{!! ++$sl !!}</td>
													<td>
                                                        @php
															$monthAndYear   = explode('-',$value->month_of_salary);

															$month = $monthAndYear[1];
															$dateObj   = DateTime::createFromFormat('!m', $month);
															$monthName = $dateObj->format('F');
															$year = $monthAndYear[0];

															$monthAndYearName = $monthName." ".$year ;
															echo $monthAndYearName;
                                                       @endphp
													</td>
													<td>
														@if($value->employee->photo != '')
															<img style=" width: 70px; " src="{!! asset('uploads/employeePhoto/'.$value->employee->photo) !!}" alt="user-img" class="img-circle">
														@else
															<img style=" width: 70px; " src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle">
														@endif
													</td>
													<td>@if(isset($value->employee->first_name)){!!  $value->employee->first_name !!} {{$value->employee->last_name}}@endif</td>
													<td>@if(isset($value->employee->payGrade->pay_grade_name)){!!  $value->employee->payGrade->pay_grade_name !!} @endif</td>
													<td>{!! $value->basic_salary !!}</td>
													<td>{!! $value->gross_salary !!}</td>
													<td>
														<span class="label label-success">Paid</span>
													</td>
													<td style="width: 100px">
															<a href="{{url('paymentHistory/generatePayslip',$value->salary_details_id)}}" target="_blank"><button  class="btn btn-success waves-effect waves-light"><span>Generate Payslip</span> </button></a>
													</td>

												</tr>
											@endforeach
										@endif
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


