@extends('admin.master')
@section('content')
@section('title')
@lang('leave.employee_leave_report')
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
        $("#leaveReport").validate();
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
								{{ Form::open(array('route' => 'leaveReport.leaveReport','id'=>'leaveReport')) }}
								<div class="col-md-1"></div>
								<div class="col-md-3">
									<div class="form-group employeeName">
										<label class="control-label" for="email">@lang('common.employee_name')<span class="validateRq">*</span></label>
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
										<input type="text" class="form-control dateField required" readonly placeholder="@lang('common.from_date')"  name="from_date" value="@if(isset($from_date)) {{$from_date}}@else {{ dateConvertDBtoForm(date('Y-01-01')) }} @endif">
									</div>
								</div>

								<div class="col-md-3">
									<label class="control-label" for="email">@lang('common.to_date')<span class="validateRq">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control dateField required" readonly placeholder="@lang('common.from_date')"  name="to_date" value="@if(isset($to_date)) {{$to_date}}@else {{ dateConvertDBtoForm(date('Y-m-d')) }} @endif">
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
						@if(count($results) > 0)
							<h4 class="text-right">
								<a class="btn btn-success" style="color: #fff" href="{{ URL('downloadLeaveReport/?employee_id='.$employee_id.'&from_date='.$from_date.'&to_date='.$to_date)}}"><i class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download') PDF</a>
							</h4>
						@endif
                        @if(!empty($results))
                            <div class="table-responsive">
                                <table id="" class="table table-bordered">
                                    <thead class="tr_header">
                                    <tr>
                                        <th style="width:100px;">@lang('common.serial')</th>
                                        <th>@lang('leave.leave_type')</th>
                                        <th>@lang('leave.applied_date')</th>
                                        <th>@lang('leave.request_duration')</th>
                                        <th>@lang('leave.approve_by')</th>
                                        <th>@lang('leave.approve_date')</th>
                                        <th>@lang('leave.purpose')</th>
                                        <th>@lang('leave.number_of_day')</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($results) > 0)
                                            {{$sl=null}}
                                            @foreach($results as $value)
                                            <tr>
                                                <td>{{++$sl}}</td>
                                                <td>@if($value->leaveType->leave_type_name) {{$value->leaveType->leave_type_name}} @endif</td>
                                                <td>{{dateConvertDBtoForm($value->application_date)}}</td>
                                                <td>{{dateConvertDBtoForm($value->application_from_date)}} <b>to</b> {{dateConvertDBtoForm($value->application_to_date)}}</td>
                                                <td>@if($value->approveBy->first_name) {{$value->approveBy->first_name}} {{$value->approveBy->last_name}} @endif</td>
                                                <td>{{dateConvertDBtoForm($value->approve_date)}}</td>
                                                <td width="300px;word-wrap: break-word">{{$value->purpose}}</td>
                                                <td>{{$value->number_of_day}}</td>
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
                        @endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
