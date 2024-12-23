
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('employee.Employee Print')</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<style>

		/* table {
			margin: 0 0 40px 0;
			width: 100%;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			display: table;
			border-collapse: collapse;

		} */
		.printHead{
			/* width: 35%; */
			margin: 0 auto;
            text-align: center;
		}
		/* table, td, th {
			border: 1px solid black;
		}
		td{
			padding: 5px;
		}

		th{
			padding: 5px;
		} */

	</style>
	<body onload="printEmployee()">
	<div class="printHead">
		@if($printHead)
			{!! $printHead->description !!}
		@endif
		<br>
		<p style="margin-left: 42px;margin-top: 10px"><b>@lang('employee.Employee Print')</b></p>
	</div>
	<div class="container-fluid">
    <div class="table-responsive">
    <table  class="table table-hover manage-u-table">
        <thead>
			<tr>
				<th>@lang('employee.Employee ID')</th>
				<th>@lang('employee.photo')</th>
				<th>@lang('employee.name')</th>
				<th>@lang('employee.department')</th>
				<th>@lang('employee.phone')</th>
				<th>@lang('employee.finger_print_no')</th>
				<th>@lang('paygrade.pay_grade_name')</th>
				<th>@lang('employee.date_of_joining')</th>
				<th>@lang('common.status')</th>
			</tr>
        </thead>
        <tbody>
        @foreach($results AS $value)
            <tr class="{!! $value->employee_id !!}">
                <td style="width: 100px;">{!! $value->employee_id !!}</td>
                <td>
                    @if($value->photo != '' && file_exists('uploads/employeePhoto/'.$value->photo))
                       <a href="{!! route('employee.show',$value->employee_id  ) !!}"><img style=" width: 70px; " src="{!! asset('uploads/employeePhoto/'.$value->photo) !!}" alt="user-img" class="img-circle"></a>
                    @else
                        <a href="{!! route('employee.show',$value->employee_id  ) !!}"> <img style=" width: 70px; " src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle"></a>
                    @endif
                </td>
                <td>
					<span class="font-medium">
                        <a href="{!! route('employee.show',$value->employee_id  ) !!}">{!! $value->first_name !!}&nbsp;{!! $value->last_name !!}</a>
					</span>
						<br/><span class="text-muted">@lang('employee.role') :
						@if(isset($value->userName->role->role_name)) {!! $value->userName->role->role_name !!} @endif
					</span>
					<br/><span class="text-muted">
						@if (isset($value->supervisor->first_name)) @lang('employee.supervisor') :  {!! $value->supervisor->first_name !!} {!! $value->supervisor->last_name !!}@endif
					</span>
                </td>
                <td>
					<span class="font-medium">
						@if (isset($value->department->department_name)) {!! $value->department->department_name !!} @endif
					</span>
                    <br/><span class="text-muted">@lang('employee.designation') :
                        @if (isset($value->designation->designation_name)) {!! $value->designation->designation_name!!} @endif
					</span>
                    <br/><span class="text-muted">
						@if (isset($value->branch->branch_name))  @lang('branch.branch_name') :  {!! $value->branch->branch_name!!} @endif
						</span>

                </td>
                <td>
					<span class="font-medium">
						{{	$value->phone}}
					</span>
                    <br/><span class="text-muted">
						@if($value->email!='')@lang('employee.email') :{!! $value->email !!}@endif
					</span>
                </td>
                <td>
                    <span class="font-medium">
                        {!! $value->finger_id !!}</td>
					</span>
                <td>
                    <span class="font-medium">
                         @if (isset($value->payGrade->pay_grade_name)) {!! $value->payGrade->pay_grade_name!!} <span class="bdColor">(@lang('employee.monthly'))</span> @endif
                        @if (isset($value->hourlySalaries->hourly_grade)) {!! $value->hourlySalaries->hourly_grade!!} <span class="bdColor">(@lang('employee.hourly'))</span>@endif
                     </span>
                </td>
                <td>
                    <span class="font-medium">
						{{dateConvertDBtoForm($value->date_of_joining)}}
					</span>
                    <br/><span class="text-muted">
                        {{ \Carbon\Carbon::parse($value->date_of_joining)->diffForHumans() }}
					</span>
                    <br/><span class="text-muted">
                        @lang('employee.job_status'): @if($value->permanent_status == 0) @lang('employee.probation_period') @else @lang('employee.permanent') @endif
					</span>
                </td>
                <td>
                    @if($value->status == 1)
                        <span class="label label-success">@lang('common.active')</span>
					</span>
                    @elseif($value->status == 2)
                        <span class="label label-warning">@lang('common.inactive')</span>
                    @else
                        <span class="label label-danger">@lang('common.terminated')</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
	</div>

 <script>
  function printEmployee()
  {
    window.print();
  }


 </script>
</body>
</html>
