@extends('admin.master')
@section('content')

@section('title')
@lang('performance.employee_performance_list')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{ route('employeePerformance.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('performance.add_employee_performance')</a>
			</div>	
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
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
								<table id="myTable" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>@lang('common.serial')</th>
											<th>@lang('common.employee_name')</th>
											<th>@lang('common.month')</th>
											<th>@lang('performance.remarks')</th>
											<th>@lang('performance.star_rating')</th>
											<th>@lang('common.action')</th>
										</tr>
									</thead>
									<tbody>
										@php $i = 1; @endphp
										@foreach($results AS $value)
											<tr class="{!! $value->employee_performance_id  !!}">
												<td style="width: 100px;">{!! $i++ !!}</td>
												<td>{!! $value->first_name !!} {{$value->last_name}} </td>
												<td>
													{{convartMonthAndYearToWord($value->month)}}
												</td>
												<td style="width:500px;word-wrap: break-word;">{!! $value->remarks !!}</td>
												<td style="width: 120px">
													<div class="PerformanceRating<?php echo $i; ?>">

													</div>
												</td>
												<td style="width: 100px;">
													<a target="_blank" title="View Details" href="{!! route('employeePerformance.show',$value->employee_performance_id  ) !!}"  class="btn btn-primary btn-xs btnColor">
														<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
													</a>
													@if($value->status !='1')
													<a title="Edit" href="{!! route('employeePerformance.edit',$value->employee_performance_id  ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a title="Delete" href="{!!route('employeePerformance.delete',$value->employee_performance_id   )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->employee_performance_id  !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													@endif
												</td>
											</tr>
											<script>
                                                $(function () {
                                                    var rating;
                                                    $(".PerformanceRating<?php echo $i; ?>").rateYo({
                                                        rating:  <?php echo $value->avgRating / 2; ?>,
                                                        ratedFill: "#FF4500"
                                                    }).on("rateyo.set", function (e, data) {

                                                    });
                                                });
											</script>
										@endforeach
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