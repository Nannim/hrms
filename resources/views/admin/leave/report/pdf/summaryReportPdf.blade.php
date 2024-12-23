
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('leave.leave_summary_report')</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
		<b>@lang('common.name') : </b>{{$employee_name}},<b>@lang('employee.department') : </b>{{$department_name}}<b>,@lang('common.from_date') : </b>{{$form_date}} , <b>@lang('common.to_date') : </b>{{$to_date}}
		<div class="table-responsive">
			<table id="" class="table table-bordered">
				<thead class="tr_header">
					<tr>
						<th style="width:100px;">@lang('common.serial')</th>
						<th>@lang('leave.leave_type')</th>
						<th>@lang('leave.number_of_day')</th>
						<th>@lang('leave.leave_consume')</th>
						<th>@lang('leave.current_balance')</th>
					</tr>
                </thead>
				<tbody>
					@if(count($results) > 0)
						{{$sl=null}}
						@foreach($results as $value)
						<tr>
							<td>{{++$sl}}</td>
							<td>{{$value['leave_type_name']}}</td>
							<td>{{$value['num_of_day']}}</td>
							<td>{{$value['leave_consume']}}</td>
							<td>{{$value['current_balance']}}</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="8">@lang('common.no_data_available') !</td>
						</tr>
					@endif
				</tbody>
			</table>
        </div>
	</div>

</body>
</html>


