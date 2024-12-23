
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Summary Report</title>
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
		<br>
	</div>
	<div class="container">
		<div class="table-responsive">
			<b>@lang('common.from_date') : </b>{{$from_month}},
			<b>@lang('common.to_date') : </b>{{$to_month}}
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
					@else
						<tr>
							<td colspan="3">@lang('common.no_data_available') !</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>


