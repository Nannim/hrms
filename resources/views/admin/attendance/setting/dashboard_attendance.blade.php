@extends('admin.master')
@section('content')
@section('title')
DashBoard Attendance Setting
@endsection
<style>
	.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
		background: none;
		color: red !important;
		cursor: default;
	}
	td{
		color:black !important;
	}
	.mt-10 {
		margin-top: 10px;
	}
</style>

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				  
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>Dashboard Attendance Setting By Ip</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
						@if($errors->any())
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								@foreach($errors->all() as $error)
									<strong>{!! $error !!}</strong><br>
								@endforeach
							</div>
						@endif
						@if(session()->has('success'))
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
							</div>
						@endif
						@if(session()->has('error'))
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<strong>{{ session()->get('error') }}</strong>
							</div>
						@endif
                           <form action="{{ route('attendance.dashboard.post') }}" method="POST"> 
                           	{{ csrf_field() }}
							<div class="form-body">
				             <div class="row">
				             	<div class="col-md-6">
				             		<div class="form-group">
				             			<label>Employee Self Attendance Status </label>
				             			<select class="form-control" name="status">
				             				<option @if($ip_setting->status == 1) selected @endif value="1">Yes User Can Give Attedance</option>
				             				<option @if($ip_setting->status == 0) selected @endif value="0">No User Can't Give Attendance</option>
				             			</select>
				             		</div>				             		

				             		<div class="form-group">
				             			<label>Should Check White Listed Ip Address ? </label>
				             			<select class="form-control" name="ip_status">
				             				<option @if($ip_setting->ip_status == 1) selected @endif value="1">Yes User Can Give Attedance Only by Whitelisted IP</option>
				             				<option @if($ip_setting->ip_status == 0) selected @endif value="0">User Can Give Attendance by Any IP</option>
				             			</select>
				             		</div>
                                   
                                    <div class="form-group">
				             		  <label>Please Enter White Listed IP Address</label>
				             		</div>
				             		<div class="form-group" id="AddRow">
                                      @if(count($white_listed_ip) > 0)
                                      @foreach($white_listed_ip as $value)
				             			<div class="aaas mt-10" style="margin-top: 10px;" id="whid{{$loop->index+1}}">
				             				<div class="col-md-10">
				             			     <input type="text" value="{{ $value->white_listed_ip }}" name="ip[]" class="form-control"  placeholder="Enter IP Address">
				             				</div>
				             				<div class="col-md-2">
				             					<button class="btn btn-danger" onclick="removeDiv(<?php echo  $loop->index+1; ?>)">X</button>
				             				</div>
				             		   </div>
                                       @endforeach
                                       
				             		   @endif


				             		</div>

				             		<div class="form-group" >
				             			<input type="hidden" name="count" id="rowcount" value="{{ $white_listed_ip->count() }}">
				             			<button type="button" style="margin-top: 10px" class="btn btn-success" id="addmore">Add More IP</button>
				             			<!-- <button type="button" style="margin-top: 10px" class="btn btn-success" onclick="addMoreField()">Add More IP</button> -->
				             		</div>
				             		

				             	</div>
				             </div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-6 text-right">
										<button type="submit" id="formSubmit" class="btn btn-info "><i class="fa fa-paper-plane"></i>Update Setting</button>
									</div>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('page_scripts')
	<script>

    	$("#addmore").click(function(){
    		var rowcount = $('#rowcount').val();

    	    var updateCount = Number(rowcount)+1;

    	    var newId = 'whid'+updateCount;

    		var headRow = $('#AddRow');
    		headRow.append("<div class='mt-10' id='"+newId+"'><div class='col-md-10'><input type='text'  name='ip[]' class='form-control' placeholder='Enter IP Address'></div><div class='col-md-2'><button type='button' class='btn btn-danger remov' onclick='removeDiv("+updateCount+")'>X</button></div></div>");

    		document.getElementById("rowcount").value = updateCount;
    	});

    	function removeDiv(id){
    		$("#whid"+id).remove();
    	}

	</script>
@endsection
