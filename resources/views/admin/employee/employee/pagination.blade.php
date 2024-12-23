<div class="table-responsive">
    <table  class="table table-hover manage-u-table">
        <thead>
			<tr>
				<th>#</th>
				<th>@lang('employee.photo')</th>
				<th>@lang('employee.name')</th>
				<th>@lang('employee.department')</th>
				<th>@lang('employee.phone')</th>
				<th>@lang('employee.finger_print_no')</th>
				<th>@lang('paygrade.pay_grade_name')</th>
				<th>@lang('employee.date_of_joining')</th>
				<th>@lang('common.status')</th>
				<th>@lang('common.action')</th>
			</tr>
        </thead>
        <tbody>
        {!! $sl=null !!}
        @foreach($results AS $value)
            <tr class="{!! $value->employee_id !!}">
                <td style="width: 100px;">{!! ++$sl !!}</td>
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

                <td style="width: 150px">
                    <a  title="Profile" href="{!! route('employee.show',$value->employee_id  ) !!}"  class="btn btn-primary btn-xs btnColor">
                        <i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
                    </a>
                    <a href="{!! route('employee.edit',$value->employee_id) !!}"  class="btn btn-success btn-xs btnColor">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <a href="{!!route('employee.delete',$value->employee_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->employee_id!!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {{$results->links()}}
    </div>
</div>