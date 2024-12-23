@extends('admin.master')
@section('content')
@section('title')
@lang('attendance.daily_attendance')
@endsection
<script>
    jQuery(function (){
        $("#dailyAttendanceReport").validate();
    });

</script>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
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
							<div id="searchBox" >
                            <div class="col-md-1"></div>
                            {{ Form::open(array('route' => 'dailyAttendance.dailyAttendance','id'=>'dailyAttendanceReport','class'=>'form-horizontal')) }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">@lang('common.date')<span class="validateRq">*</span>:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control dateField" required readonly placeholder="@lang('common.date')" id="date" name="date" value="@if(isset($formData)) {{$formData}}@else {{ dateConvertDBtoForm(date('Y-m-d')) }} @endif">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" id="filter" style="margin-top: 2px; width: 100px;" class="btn btn-info " value="@lang('common.filter')">
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                        <hr>
							@if(count($results) > 0)
								<h4 class="text-right">
									@if(isset($formData))
										<a target="_blank" class="btn btn-success" style="color: #fff" href="{{ URL('downloadDailyAttendance/'.dateConvertFormtoDB($formData))}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
									@else
										<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadDailyAttendance/'.date('Y-m-d') )}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
									@endif
								</h4>
							@endif
							<div class="table-responsive">
								<table id="" class="table table-bordered">
									<thead class="tr_header">
										<tr>
											<th style="width:100px;">@lang('common.serial')</th>
											<th>@lang('common.date')</th>
											<th>@lang('common.employee_name')</th>
											<th>@lang('attendance.in_time')</th>
											<th>@lang('attendance.out_time')</th>
											<th>@lang('attendance.working_time')</th>
											<th>@lang('attendance.late')</th>
											<th>@lang('attendance.late_time')</th>
											<th>@lang('attendance.over_time')</th>
										</tr>
									</thead>
									<tbody>
									@if(count($results) > 0)
										@foreach($results AS $key=>$data)
											<tr>
												<td colspan="9"><strong>{{$key}}</strong></td>
											</tr>
											@foreach($data as $key1=>$value)
												<tr>
													<td>{{++$key1}}</td>
													<td>{{$value->date}}</td>
													<td>{{$value->fullName}}</td>
													<td>{{$value->in_time}}</td>
													<td>
														@php
															if ($value->out_time != '') {
																echo $value->out_time;
															} else {
																echo "--";
															}
														@endphp
													</td>

													<td>
														 @php
															if ($value->working_time != '00:00:00') {
																echo date('H:i', strtotime($value->working_time));
															} else {
																echo 'One Time Punch';
															}
														 @endphp
													</td>
													<td>
														@php
															if($value->ifLate == "Yes"){
																echo "<b style='color: red'>".$value->ifLate."</b>";
															}else{
																echo "No";
															}
														@endphp
													</td>
													<td>
														@php
															if (date('H:i', strtotime($value->totalLateTime)) != '00:00') {
																echo date('H:i', strtotime($value->totalLateTime));
															}else{
															   echo "--";
															}
														@endphp
													</td>
													<td>
														@php
															$workingHour = new DateTime($value->workingHour);
															$workingTime = new DateTime($value->working_time);
															if($workingHour < $workingTime){
																$interval = $workingHour->diff($workingTime);
																echo $interval->format('%H:%I');
															}else{
																echo "00:00";
															}
														@endphp
													</td>
												</tr>
											@endforeach
										@endforeach
									@else
										<tr>
											<td colspan="9">@lang('common.no_data_available') !</td>
										</tr>
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
