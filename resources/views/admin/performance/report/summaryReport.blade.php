@extends('admin.master')
@section('content')
@section('title')
@lang('performance.performance_summary_report')
@endsection
<style>
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

</style>
<script>
    jQuery(function (){
        $("#performanceSummaryReport").validate();
     });

</script>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<div class="row">
							<div id="searchBox">
								{{ Form::open(array('route' => 'performanceSummaryReport.performanceSummaryReport','id'=>'performanceSummaryReport')) }}
								<div class="col-md-1"></div>
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label class="control-label" for="email">@lang('common.employee')<span class="validateRq">*</span></label>
										<select class="form-control employee_id select2 required" required name="employee_id">
											<option value="">---- @lang('common.please_select') ----</option>
											@foreach($employeeList as $value)
												<option value="{{$value->employee_id}}"  @if(@$value->employee_id == $employee_id) {{"selected"}} @endif>{{$value->first_name}} {{$value->last_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label class="control-label" for="email">@lang('common.from_date')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control monthField required" readonly placeholder="@lang('common.from_date')"  name="from_month" value="@if(isset($from_month)) {{$from_month}}@else {{ date('Y-01') }} @endif">
									</div>
								</div>

								<div class="col-md-3">
									<label class="control-label" for="email">@lang('common.to_date')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control monthField required" readonly placeholder="@lang('common.to_date')"  name="to_month" value="@if(isset($to_month)) {{$to_month}}@else {{  date("Y-m") }} @endif">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<input type="submit" id="filter" style="margin-top: 25px; width: 100px;" class="btn btn-info " value="@lang('common.filter')">
									</div>
								</div>
								{{ Form::close() }}
							</div>
							</div>
						<hr>
						@if($results && count($results) > 0)
							<div class="row">
								<div class="col-md-12 text-right">
									<h4 style="">
										<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadPerformanceSummaryReport/?employee_id='.$employee_id.'&from_month='.$from_month.'&to_month='.$to_month)}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
									</h4>
								</div>
							</div>
						@endif
						@if($results)
							<div class="table-responsive">
								<table id="" class="table table-bordered">
									<thead class="tr_header">
									<tr>
										<th style="width:100px;">@lang('common.serial')</th>
										<th>@lang('common.month')</th>
										<th style="width: 500px">@lang('performance.rating') (@lang('performance.out_of_ten'))</th>
									</tr>
									</thead>
									<tbody>
										@if(count($results) > 0)
											@php
												$serial = 0;
												$totalRating = 0;
												$item = 0;
											@endphp
											@foreach($results AS $value)
												@php
													$item++;
													$totalRating += round($value->avgRating,2);
												@endphp
												<tr>
													<td style="width:100px;">{{++$serial}}</td>
													<td>{{convartMonthAndYearToWord($value->month) }}</td>
													<td>{{round($value->avgRating,2)}}</td>
												</tr>
											@endforeach
											<tr>
												<td colspan="1"></td>
												<td class="text-right"><b>@lang('common.employee_name'): &nbsp;</b></td>
												<td ><b></b> {{$value->first_name }} {{$value->last_name }} ({{$value->department_name}})</td>
											</tr>
											<tr>
												<td colspan="1"></td>
												<td class="text-right"><b>@lang('performance.total_rating'): &nbsp;</b></td>
												<td ><b></b> {{ $totalRating }} </td>
											</tr>
											<tr>
												<td colspan="1"></td>
												<td class="text-right"><b>@lang('performance.average_rating'): &nbsp;</b></td>
												<td ><b></b> {{ $totalRating / $item }} </td>
											</tr>
											<tr>
												<td colspan="1"></td>
												<td class="text-right"><b>@lang('performance.star_rating'): &nbsp;</b></td>
												<td>
													<span class="PerformanceRating"></span>
												 </td>
											</tr>

											<script>
												$(function () {
													var rating;
													$(".PerformanceRating").rateYo({
														rating:  <?php echo ($totalRating/ $item) / 2 ?>,
														ratedFill: "#FF4500"
													}).on("rateyo.set", function (e, data) {

													});
												});
											</script>
										@else
											<tr>
												<td colspan="3">@lang('common.no_data_available') !</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
