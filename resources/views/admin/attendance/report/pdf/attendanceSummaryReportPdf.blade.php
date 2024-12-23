
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('attendance.attendance_summary_report')</title>
		<meta charset="utf-8">
	</head>

	<style>
		table {
			margin: 0 0 40px 0;
			width: 100%;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			display: table;
			border-collapse: collapse;
		}
		.printHead{
			width: 35%;
			margin: 0 auto;
		}
		table, td, th {
			font-size: 10px;
			border: 1px solid black;
		}
		td{
			font-size: 8px;
			padding: 3px;
		}

		th{
			padding: 3px;
		}
		.present{
			color: #7ace4c;
			font-weight: 700;
		}
		.absence{
			color: #f33155;
			font-weight: 700;
		}
		.leave{
			color: #41b3f9;
			font-weight: 700;
		}
		.bolt{
			font-weight: 700;
		}

	</style>
	<body>
	<div class="printHead">
		@if($printHead)
			{!! $printHead->description !!}
		@endif
		<p style="margin-left: 42px;margin-top: 10px"><b>@lang('attendance.attendance_summary_report')</b></p>
	</div>
	<div class="container">
		<b>Month : </b>{{$month}}
			@php
				 $colCount  = count($monthToDate);
				 $colCount  += count($leaveTypes) + 3;
			@endphp

		<div class="table-responsive">
		<table  class="table table-bordered">
			<thead>
				<tr>
					<th>@lang('common.serial')</th>
					<th>@lang('common.year')</th>
					<th colspan="{{$colCount}}">@lang('common.month')</th>
				</tr>
				<tr>
					<th>#</th>
					<th>@if(isset($month)) @php

                                              $exp = explode('-',$month);
                                              echo  $exp[0] ;
										 @endphp @else {{ date("Y") }}  @endif</th>
					<th>{{$monthName}}</th>
					@foreach($monthToDate as $head)
						<th>{{$head['day_name']}}</th>
					@endforeach
					<th>@lang('attendance.day_of_worked')</th>
					<th>@lang('attendance.gov_day_work') </th>
					@foreach($leaveTypes as $leaveType)
						<th>{{$leaveType->leave_type_name}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>#</td>
					<th>@lang('common.name')</th>
					<th>@lang('employee.designation')</th>
					@foreach($monthToDate as $head)
						<th>{{$head['day']}}</th>
					@endforeach
					<th>#</th>
					<th>#</th>
					@foreach($leaveTypes as $leaveType)
						<th>#</th>
					@endforeach
				</tr>

				@php
					$sl = null;
					$totalPresent = 0;
					$totalGovDayWorked = 0;
					$leaveData = [];
					$totalCol = 0;
				@endphp
				@foreach($results as $key => $value)
					<tr>
						<td>{{++$sl}}</td>
						<td>{{$key}}</td>
						<td>{{$value[0]['designation_name']}}</td>
						@foreach($value as $v)
							@php
									if($sl == 1){
										$totalCol ++;
									}
									if($v['attendance_status'] == 'present'){
										if($v['gov_day_worked'] == 'yes'){
											$totalGovDayWorked++;
										}
										$totalPresent++;
										echo  "<td><span class='present' title='Present'>P</span></td>";
									}elseif($v['attendance_status'] == 'absence'){
										echo  "<td><span class='absence' title='Absence'>A</span></td>";
									}elseif($v['attendance_status'] == 'leave'){
										$leaveData[$key][$v['leave_type']][] = $v['leave_type'];
										echo  "<td><span class='leave' title='Leave'>L</span></td>";
									}else{
										echo  "<td></td>";
									}
							@endphp
						@endforeach
						<td><span class="bolt">{{$totalPresent}}</span></td>
						<td><span class="bolt">{{$totalGovDayWorked}}</span></td>

						@foreach($leaveTypes as $leaveType)

							<td>
								<span class="bolt">
									@php
										if($sl == 1){
											$totalCol ++;
										}
										if (isset($leaveData[$key][$leaveType->leave_type_name]))
											$c = count($leaveData[$key][$leaveType->leave_type_name]);
										else
											$c = 0;
									@endphp
									{{ $c }}
								</span>
							</td>
						@endforeach
						@php
							 $totalPresent = 0;
							 $totalGovDayWorked = 0;

						@endphp
					</tr>
				@endforeach
				<script>
					{!!"document.getElementById('totalCol').setAttribute('colspan', $totalCol+3);" !!}
				</script>
			</tbody>
		</table>
	</div>
	</div>

</body>
</html>


