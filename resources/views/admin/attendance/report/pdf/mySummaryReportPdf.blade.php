<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('attendance.my_attendance_report')</title>
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
			border: 1px solid black;
		}
		td{
			padding: 5px;
		}

		th{
			padding: 5px;
		}

	</style>
	<body>
		<div class="printHead">
			@if($printHead)
				{!! $printHead->description !!}
			@endif
			<br>
			<p style="margin-left: 42px;margin-top: 10px"><b>@lang('attendance.my_attendance_report')</b></p>
		</div>
		<div class="container">
			<b>@lang('common.name') : </b>{{$employee_name}},<b>@lang('employee.department') : </b>{{$department_name}}<b>,@lang('common.from_date') : </b>{{$form_date}} , <b>@lang('common.to_date') : </b>{{$to_date}}
			<table id="" class="table table-bordered">
			<thead class="tr_header">
								<tr>
									<th style="width:100px;">@lang('common.serial')</th>
									<th>@lang('common.date')</th>
									<th>@lang('attendance.in_time')</th>
									<th>@lang('attendance.out_time')</th>
									<th>@lang('attendance.working_time')</th>
									<th>@lang('attendance.late')</th>
									<th>@lang('attendance.late_time')</th>
									<th>@lang('attendance.over_time')</th>
									<th>@lang('common.status')</th>
								</tr>
								</thead>
								<tbody>
                                <?php
                                $totalPresent = 0;
                                $totalAbsence = 0;
                                $totalLeave   = 0;
								$totalLate    = 0;
								$totalHour    = 0;
                                $totalMinit   = 0;
                                ?>

								{{$serial = null}}
								@if(count($results) > 0)
									@foreach($results AS $value)

										<tr>
											<td style="width:100px;">{{++$serial}}</td>
											<td>{{ $value['date'] }}</td>
											<td>
                                                <?php
                                                if ($value['in_time'] != '') {
                                                    echo $value['in_time'];
                                                } else {
                                                    echo "--";
                                                }
                                                ?>
											</td>
											<td>
                                                <?php
                                                if ($value['out_time'] != '') {
                                                    echo $value['out_time'];
                                                } else {
                                                    echo "--";
                                                }
                                                ?>
											</td>

											<td>
                                                <?php
													if( $value['working_time'] ==''){
                                                        echo "--";
													}else{
                                                        if ($value['working_time'] != '00:00:00' ) {
                                                            echo $d =  date('H:i', strtotime($value['working_time']));

                                                            $hour_minit = explode(':',$d);

                                                            $totalHour += $hour_minit[0];
                                                            $totalMinit += $hour_minit[1];
                                                             

                                                        } else {
                                                            echo 'One Time Punch';
                                                        }
													}

                                                ?>
											</td>
											<td>
                                                <?php
													if($value['ifLate'] == ''){
													    echo "--";
													}else{
														if($value['ifLate'] == 'Yes'){
															echo "<b style='color: red'>".__('common.yes')."</b>";
															$totalLate +=1;
														}else{
															echo __('common.no');
														}
                                                    }

                                                ?>
											</td>
											<td>
                                                <?php
													if($value['totalLateTime'] ==''){
                                                        echo "--";
													}else{
                                                        if ($value['totalLateTime'] != '00:00:00') {
                                                            echo date('H:i', strtotime($value['totalLateTime']));
                                                        }else{
                                                            echo "--";
                                                        }
													}
                                                ?>

											</td>
											<td>
                                                <?php
												if($value['workingHour'] == '')	{
												    echo "--";
												}else{
													$workingHour = new DateTime($value['workingHour']);
													$workingTime = new DateTime($value['working_time']);
													if($workingHour < $workingTime){
														$interval = $workingHour->diff($workingTime);
														echo $interval->format('%H:%I');
													}else{
														echo "--";
													}
                                                }
                                                ?>
											</td>
											<td>
                                                <?php
                                                if($value['action'] =='Absence'){
                                                    echo "<span class='label label-danger'>".__('common.absence')."</span>";
                                                    $totalAbsence +=1;
                                                }elseif($value['action'] =='Leave'){
                                                    echo "<span class='label label-info'>".__('common.leave')."</span></p>";
                                                    $totalLeave +=1;
                                                }else{
                                                    echo "<span class='label label-success'>".__('common.present')."</span>";
                                                    $totalPresent +=1;
                                                }
                                                ?>
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="7">@lang('common.no_data_available') !</td>
									</tr>
								@endif
                               <?php 

								$total_working_hour = (($totalHour*60)+$totalMinit)/60;

								?>
								@if(count($results) > 0)
									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.total_working_days'): &nbsp;</b></td>
										<td style="background: #eee"><b>{{$serial}}</b>  @lang('common.days')</td>
									</tr>
									<tr>
										<td colspan="7"></td>
										<td style="background: #fff"><b>@lang('attendance.total_present'): &nbsp;</b></td>
										<td style="background: #fff"><b>{{$totalPresent}}</b> @lang('common.days')</td>
									</tr>
									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.total_absence'): &nbsp;</b></td>
										<td style="background: #eee"><b>{{$totalAbsence}}</b> @lang('common.days')</td>
									</tr>
									<tr>
										<td colspan="7"></td>
										<td style="background: #fff"><b>@lang('attendance.total_leave'): &nbsp;</b></td>
										<td style="background: #fff"><b>{{$totalLeave}}</b> @lang('common.days')</td>
									</tr>
									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.total_late'): &nbsp;</b></td>
										<td style="background: #eee"><b>{{$totalLate}}</b> @lang('common.days')</td>
									</tr>


								     <tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.expected_working_hour'): &nbsp;</b></td>
										<td style="background: #eee"><b>{{ $expected = $totalPresent*8 }}</b> @lang('common.hours')</td>
									</tr>	

									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.actual_working_hour'): &nbsp;</b></td>
										<td style="background: #eee"><b>{{round($total_working_hour)}}</b> @lang('common.hours')</td>
									</tr>	
                                    
                                    <?php
                                      $overtime = $total_working_hour - $expected;
                                     ?>
									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.over_time'): &nbsp;</b></td>
										<td style="background: #eee"><b>@if($overtime > 0) {{ round($overtime) }} @else 0 @endif</b> @lang('common.hours')</td>
									</tr>	

									<tr>
										<td colspan="7"></td>
										<td style="background: #eee"><b>@lang('attendance.deficiency'): &nbsp;</b></td>
										<td style="background: #eee"><b>@if($overtime < 0) {{ round($overtime)  }} @else 0 @endif</b> @lang('common.hours')</td>
									</tr>
								@endif
								</tbody>
			</table>
		</div>
	</body>
</html>
