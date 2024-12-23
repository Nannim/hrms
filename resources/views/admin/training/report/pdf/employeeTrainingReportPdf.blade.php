<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('training.employee_training_report')</title>
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
		tbody{
			font-weight: 100;

		}

	</style>
	<body>
	<div class="printHead">
		@if($printHead)
			{!! $printHead->description !!}
		@endif
		<br>
		<br>
	</div>
	<div class="container">
		<b>@lang('common.name') : </b>{{$employee_name}},<b>@lang('employee.department') : </b>{{$department_name}}<b>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th style="width:100px;">@lang('common.serial')</th>
						<th>@lang('training.training_type')</th>
                        <th>@lang('training.training_duration')</th>
                        <th>@lang('common.status')</th>

					</tr>
				</thead>
				<tbody>
					@if(count($results) > 0)
						{{$sl=null}}
						@foreach($results as $value)
						<tr>
							<td>{{++$sl}}</td>
							<td>{{$value['training_type_name']}}</td>
							@if($value['start_date'] !='')
								 <td>{{$value['start_date']}} <b>To</b> {{$value['end_date']}}</td>
							@else
								<td>--</td>
							@endif
							<td>
							@php
								if($value['action'] == "Yes"){
									echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i></b>";
								}else{
									echo "--";
								}
							@endphp
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4">@lang('common.no_data_available') !</td>
						</tr>
					@endif
				</tbody>
			</table>
        </div>
	</div>

</body>
</html>


