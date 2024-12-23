<div class="table-responsive">
    <table  class="table table-hover manage-u-table">
        <thead>
			<tr>
				<th>#</th>
				<th>@lang('employee.photo')</th>
				<th>@lang('employee.name')</th>
				<th>@lang('employee.department')</th>
				<th>@lang('employee.phone')</th>
				<th title="finger_id or face id or external machine id">@lang('employee.finger_print_no')</th>
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
                        <img style=" width: 70px; " src="{!! asset('uploads/employeePhoto/'.$value->photo) !!}" alt="user-img" class="img-circle">
                    @else
                        <img style=" width: 70px; " src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle">
                    @endif
                </td>
                <td>
					<span class="font-medium">
						{!! $value->first_name !!}&nbsp;{!! $value->last_name !!}
					</span>
						<br/><span class="text-muted">Role :
						@if(isset($value->userName->role->role_name)) {!! $value->userName->role->role_name !!} @endif
					</span>
					<br/><span class="text-muted">
						@if (isset($value->supervisor->first_name)) Supervisor :  {!! $value->supervisor->first_name !!} {!! $value->supervisor->last_name !!}@endif
					</span>
                </td>
                <td>
					<span class="font-medium">
						@if (isset($value->department->department_name)) {!! $value->department->department_name !!} @endif
					</span>
                    <br/><span class="text-muted">Designation :
                        @if (isset($value->designation->designation_name)) {!! $value->designation->designation_name!!} @endif
					</span>
                    <br/><span class="text-muted">
						@if (isset($value->branch->branch_name))  Branch :  {!! $value->branch->branch_name!!} @endif
						</span>

                </td>
                <td>
					<span class="font-medium">
						{{	$value->phone}}
					</span>
                    <br/><span class="text-muted">
						@if($value->email!='')Email :{!! $value->email !!}@endif
					</span>
                </td>
                <td>
                    <span class="font-medium">
                        {!! $value->finger_id !!}</td>
					</span>
                <td>
                    <span class="font-medium">
                         @if (isset($value->payGrade->pay_grade_name)) {!! $value->payGrade->pay_grade_name!!} <span class="bdColor">(Monthly)</span> @endif
                        @if (isset($value->hourlySalaries->hourly_grade)) {!! $value->hourlySalaries->hourly_grade!!} <span class="bdColor">(Hourly)</span>@endif
                     </span>
                </td>
                <td>
                    <span class="font-medium">
						{{dateConvertDBtoForm($value->date_of_joining)}}
					</span>
                    <br/><span class="text-muted">
                        {{ \Carbon\Carbon::parse($value->date_of_joining)->diffForHumans() }}
					</span>
                </td>
                <td>
                    <select class="form-control permanent_status">
                        <option value="0">@lang('employee_permanent.probation_period')</option>
                        <option value="1">@lang('employee_permanent.permanent')</option>
                    </select>
                </td>
                <input type="hidden" class="employee_id" value="{{$value->employee_id}}">
                <td style="width: 150px">
                    <button type="button" class="btn btn-sm btn-success updateStatus">
                    @lang('employee_permanent.update_status')
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {{$results->links()}}
    </div>
</div>