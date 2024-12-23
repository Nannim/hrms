@extends('admin.master')
@section('content')
@section('title','Requested Application Details')
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
					<li>@yield('title')</li>
				  
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>Application Details</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="row">
                             <div class="col-md-6">
                                 <h3 class="box-title">Employee Leave Application Details</h3>
                                 <hr>
                                 <div class="form-group">
                                     @if(isset($leaveApplicationData->employee->photo) && $leaveApplicationData->employee->photo !='')
                                        <img style="width: 70px;margin: 0 auto" class="profile-user-img img-responsive img-circle" src="{!! asset('uploads/employeePhoto/'.$leaveApplicationData->employee->photo) !!}" alt="User profile picture">
                                     @else
                                         <img style="margin: 0 auto" class="profile-user-img img-responsive img-circle" src="{!! asset('admin_assets/img/default.png') !!}" alt="User profile picture">
                                     @endif
                                     <p class="text-center" style=" margin-top: 5px;font-size: 18px;"><b> @if(isset($leaveApplicationData->employee->designation->designation_name)){{$leaveApplicationData->employee->designation->designation_name}}@endif</b></p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6">Employee Name :</label>
                                     <p class="col-md-6 col-sm-6">
                                         @if(isset($leaveApplicationData->employee->first_name)){{$leaveApplicationData->employee->first_name}}@endif
                                         @if(isset($leaveApplicationData->employee->last_name)){{$leaveApplicationData->employee->last_name}}@endif
                                     </p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6 ">Leave Type :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->leaveType->leave_type_name)){{$leaveApplicationData->leaveType->leave_type_name}}@endif</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6">Applied On :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->application_date)){{ dateConvertDBtoForm($leaveApplicationData->application_date)  }}@endif</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6 ">Request From Date :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->application_date)){{ dateConvertDBtoForm($leaveApplicationData->application_from_date)  }}@endif</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6 ">Request To Date :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->application_date)){{ dateConvertDBtoForm($leaveApplicationData->application_to_date)  }}@endif</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6 ">Number of days :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->application_date)){{ $leaveApplicationData->number_of_day }}@endif</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-md-6 col-sm-6">purpose :</label>
                                     <p class="col-md-6 col-sm-6">@if(isset($leaveApplicationData->purpose)){{ $leaveApplicationData->purpose }}@endif</p>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                <h3 class="box-title">Update Status</h3>
                                <hr>
                                 {{ Form::open(array('route' => array('requestedApplication.update', $leaveApplicationData->leave_application_id), 'method' => 'PUT','files' => 'true','id' => 'leaveApproveOrRejectForm')) }}

                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4">Current Balance :</label>
                                     <p class="col-sm-8">@if(isset($currentBalance)) {{$currentBalance}} @endif days</p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4 ">From Date :</label>
                                     <p class="col-sm-8"><input type="text" readonly class="form-control" value="@if(isset($leaveApplicationData->application_date)){{ dateConvertDBtoForm($leaveApplicationData->application_from_date)  }}@endif"></p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4 ">To Date :</label>
                                     <p class="col-sm-8"><input type="text" readonly class="form-control" value="@if(isset($leaveApplicationData->application_to_date)){{ dateConvertDBtoForm($leaveApplicationData->application_to_date)  }}@endif"></p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4 ">Number of days :</label>
                                     <p class="col-sm-8"> <input type="text" class="form-control" value="@if(isset($leaveApplicationData->application_date)){{ $leaveApplicationData->number_of_day }}@endif" readonly></p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4">Remarks :</label>
                                     <p class="col-sm-8"><textarea class="form-control" cols="10" rows="6" name="remarks" required placeholder="Enter remarks....."  value="@if(isset($leaveApplicationData->remarks)){{ $leaveApplicationData->remarks }}@endif"></textarea></p>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-4"></label>
                                     <p class="col-sm-8">
                                            <button type="submit" name="status" class="btn btn-info btn_style" value="2">Approve</button>
                                            <button type="submit" name="status" class="btn btn-danger btn_style" value="3"> Reject</button>
                                     </p>
                                 </div>
                                 {{ Form::close() }}
                                 
                             </div>
                         </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


