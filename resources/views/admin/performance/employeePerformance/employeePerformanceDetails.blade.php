@extends('admin.master')
@section('content')
@section('title')
@lang('performance.employee_performance_details')
@endsection

<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
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

						<div class="form-body">
								<div class="" style="margin-bottom:5px">
									<strong>Employee Name :</strong>
									<span class="employee_name"></span>
								</div>
								<div class="" style="margin-bottom:5px ">
									<strong>Department :</strong>
									<span class="department_name"></span>
								</div>
								<div class="" style="margin-bottom:5px ">
									<strong>Month :</strong>
									<span class="month"></span>
								</div>
								<br>

							<div class="row">
								<div class="col-md-12">
									<table class="table table-bordered table-hover">
										<thead>
											<tr class="">
												<th class="col-md-4">@lang('peformance.category_name')</th>
												<th class="col-md-5">@lang('peformance.criteria_name') </th>
												<th class="col-md-3">@lang('performance.rating') (@lang('performance.out_of_ten'))</th>
											</tr>
										</thead>
										<tbody>
											@php
												$totalRating = 0;
												$totalItem = 0;
											@endphp
											@foreach($criteriaDataFormat as $key => $value)
												<tbody class="report_row">
													<tr>
														<td rowspan="{{count($value)}}">{{$key}}</td>
														<td>{{$value[0]['performance_criteria_name']}}</td>
														<td>
															{{$value[0]['rating']}}
															@php
																$totalRating += $value[0]['rating'];
                                                                $totalItem +=1 ;
																$full_name = $value[0]['first_name']." ".$value[0]['last_name'];
																$department_name = $value[0]['department_name'];

																$monthAndYear   = explode('-',$value[0]['month']);

																$month = $monthAndYear[1];
																$dateObj   = DateTime::createFromFormat('!m', $month);
																$monthName = $dateObj->format('F');
																$year = $monthAndYear[0];

																$monthAndYearName = $monthName." ".$year ;
															@endphp
														</td>
													</tr>
													<script>
														{!!"$('.employee_name').html('$full_name');" !!}
														{!!"$('.department_name').html('$department_name');" !!}
														{!!"$('.month').html('$monthAndYearName');" !!}
													</script>
													@foreach($value as $k => $v)
														@if($k !=0)
															<tr>
																<td>{{$v['performance_criteria_name']}}</td>
																<td>
																	{{$v['rating']}}
																	@php
																		$totalRating += $v['rating'];
                                                                        $totalItem +=1 ;
																	@endphp
																</td>
															</tr>
														@endif
													@endforeach
												</tbody>
											@endforeach
											<tr>
												<td colspan="2" class="text-right">  <b>@lang('performance.total_rating') :</b></td>
												<td> <b>{{$totalRating}}</b></td>
											</tr>
											<tr>
												<td colspan="2" class="text-right">  <b>@lang('performance.average_rating') :</b></td>
												<td>
													<b>
														@php
															if($totalItem !=0 && $totalRating !=0){
																echo round($totalRating / $totalItem,2);
															}else{
																echo 0;
															}
														@endphp
													</b>
												</td>
											</tr>
											<tr>
												<td colspan="2" class="text-right">  <b>@lang('performance.star_rating') :</b></td>
												<td>
														<div class="PerformanceRating"></div>
												</td>
											</tr>
										</tbody>
									</table>
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
<script>
    $(function () {
        var rating;
        $(".PerformanceRating").rateYo({
            rating:  <?php if($totalRating != 0 && $totalItem != 0){
																echo round($totalRating / $totalItem,2) / 2;
															} ?>,
            ratedFill: "#FF4500"
        }).on("rateyo.set", function (e, data) {

        });


    });
</script>
@endsection

