@extends('admin.master')
@section('content')
@section('title','Dashboard')
<style>
    .box {
        position: relative;
        background: #ffffff;
        width: 100%;
    }
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
    }
    .profile-user-img {
        margin: 0 auto;
        width: 100px;
        padding: 3px;
        border: 3px solid #d2d6de;
    }
    @if(count($attendanceData) >= 6)
        tbody {
            display:block;
            height:320px;
            overflow:auto;
        }
        thead, tbody tr {
            display:table;
            width:100%;
            table-layout:fixed;
        }
        thead {
            width: calc( 100% - 1em )
        }
    @endif
     @if(count($leaveApplication) >= 1)
        .leaveApplication{
            overflow-x: hidden;
            height: 210px;
        }
    @endif
    @if(count($notice) >= 1)
        .noticeBord{
            overflow-x: hidden;
            height: 210px;
        }
    @endif
    @if(count($warning) >= 1)
        .warning{
            overflow-x: hidden;
            height: 210px;
        }
    @endif
</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        
        @if($ip_attendance_status == 1)
        <!-- employe attendance  -->
        @php
          $logged_user = employeeInfo();
        @endphp
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title">Hey {!!   $logged_user[0]->user_name !!} please Check in/out your attendance</h3>
                <hr>
                <div class="noticeBord">
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
                   <form action="{{ route('ip.attendance') }}" method="POST">
                    {{ csrf_field() }}
                       <p>Your IP is   {{ \Request::ip() }}</p>
                       <input type="hidden" name="employee_id" value="{{ $logged_user[0]->user_name }}">  

                       <input type="hidden" name="ip_check_status" value="{{ $ip_check_status }}">                       
                       <input type="hidden" name="finger_id" value="{{ $logged_user[0]->finger_id }}">
                     @if($count_user_login_today > 0)
                       <button class="btn btn-danger">
                        <i class="fa fa-clock-o"> </i>
                       Check Out
                      </button>                       
                     @else
                      <button class="btn btn-primary">
                        <i class="fa fa-clock-o"> </i>
                       Check In
                      </button>
                    @endif

                   </form>
                </div>
            </div>
        </div>

        <!-- end attendance  -->
        @endif

        <div class="col-md-6">
            <div class="panel">
                <div class="p-30">
                    <div class="row">
                        @if($employeeInfo->photo !='')
                            <div class="col-xs-4 col-sm-4"><img src="{!! asset('uploads/employeePhoto/'.$employeeInfo->photo) !!}" alt="varun" class="img-circle img-responsive"></div>
                        @else
                            <div class="col-xs-4 col-sm-4"><img src="{!! asset('admin_assets/img/profilePic.png') !!}" alt="varun" class="img-circle img-responsive"></div>
                        @endif
                        <div class="col-xs-12 col-sm-8">
                            <h2 class="m-b-0">{{$employeeInfo->first_name}} {{$employeeInfo->last_name}}</h2>
                            <h4>{{$employeeInfo->designation->designation_name}}</h4><a href="{{url('profile')}}" class="btn btn-rounded btn-success"><i class="ti-user m-r-5"></i> PROFILE </a></div>
                    </div>
                    <div class="row text-center m-t-30">
                        <div class="col-xs-6 b-r">
                            <h2>{{$employeeTotalLeave->totalNumberOfDays}}</h2>
                            <h4>LEAVE CONSUME</h4>
                        </div>

                        <div class="col-xs-6">
                            <h2>{{$employeeTotalAward->totalAward}}</h2>
                            <h4>AWARD</h4>
                        </div>
                    </div>
                </div>
                <hr class="m-t-10" />
            </div>
        </div>

        <div class="col-md-6 col-sm-12 col-lg-6">
            <div class="panel">
                <div class="panel-heading" style="text-transform: uppercase">{{date('F Y')}}, Attendance </div>
                <div class="table-responsive">
                    <table class="table table-hover manage-u-table">
                        <thead>
                        <tr>
                            <th  class="text-center"> # </th>
                            <th> @lang('common.date') </th>
                            <th> @lang('dashboard.in_time') </th>
                            <th> @lang('dashboard.out_time')</th>
                            <th> @lang('dashboard.late') </th>
                            <th> @lang('common.status') </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($attendanceData) > 0)
                            {{$dailyAttendanceSl =null }}
                            @foreach($attendanceData as  $dailyAttendance)
                                <tr>
                                    <td class="text-center">{{ ++$dailyAttendanceSl }}</td>


                                    <td>{{$dailyAttendance['date']}} </td>
                                    <td>
                                        @if($dailyAttendance['in_time'] !='')
                                            {{ date('h:i a', strtotime($dailyAttendance['in_time']))}}
                                        @else
                                            {{  "--"}}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            if($dailyAttendance['out_time'] !=''){
                                               echo date('h:i a', strtotime($dailyAttendance['out_time']));
                                            }else{
                                                echo "--";
                                            }
                                       @endphp
                                    </td>

                                    <td>
                                         @php
                                            if($dailyAttendance['totalLateTime'] !=''){
                                                if (date('H:i', strtotime($dailyAttendance['totalLateTime'])) != '00:00') {
                                                    echo "<b style='color: red;'>".date('H:i', strtotime($dailyAttendance['totalLateTime']))."</b>";
                                                }else{
                                                    echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i></b>";
                                                }
                                            }else{
                                                echo "--";
                                            }
                                         @endphp
                                    </td>
                                    <td>
                                        @php
                                            if($dailyAttendance['action'] =='Absence'){
                                                echo "<span class='label label-danger'>Absence</span>";
                                            }elseif($dailyAttendance['action'] =='Leave'){
                                                echo "<span class='label label-info'>Leave</span></p>";
                                            }else{
                                                echo "<span class='label label-success'>Present</span>";
                                            }
                                        @endphp
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">@lang('common.no_data_available')</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(count($leaveApplication) > 0)
            <div class="col-md-12 col-lg-6 col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">@lang('dashboard.recent_leave_application')</h3>
                    <hr>
                    <div class="leaveApplication">
                        @foreach($leaveApplication as $leaveApplication)
                            <div class="comment-center p-t-10 {{$leaveApplication->leave_application_id}}">
                                <div class="comment-body">
                                    @if($leaveApplication->employee->photo !='')
                                        <div class="user-img"> <img src="{!! asset('uploads/employeePhoto/'.$leaveApplication->employee->photo) !!}" alt="user" class="img-circle"></div>
                                    @else
                                        <div class="user-img"> <img src="{!! asset('admin_assets/img/default.png') !!}" alt="user" class="img-circle"></div>
                                    @endif
                                    <div class="mail-contnet" >
                                        @php
                                            $d = strtotime($leaveApplication->created_at);
                                        @endphp
                                        <h5>{{$leaveApplication->employee->first_name}} {{$leaveApplication->employee->last_name}}</h5><span class="time">{{date(" d M Y h:i: a", $d)}}</span> <span class="label label-rouded label-info">PENDING</span>
                                        <br/><span class="mail-desc" style="max-height: none">
                                    @lang('leave.leave_type') : {{$leaveApplication->leaveType->leave_type_name}}<br>
                                    @lang('leave.request_duration') : {{dateConvertDBtoForm($leaveApplication->application_from_date)}} To {{dateConvertDBtoForm($leaveApplication->application_to_date)}}<br>
                                    @lang('leave.number_of_day') : {{$leaveApplication->number_of_day}} <br>
                                    @lang('leave.purpose') : {{$leaveApplication->purpose}}
                                </span>

                                        <a href="javacript:void(0)" data-status=2 data-leave_application_id="{{$leaveApplication->leave_application_id}}" class="btn remarksForLeave btn btn-rounded btn-success btn-outline m-r-5"><i class="ti-check text-success m-r-5"></i>@lang('common.approve')</a>
                                        <a href="javacript:void(0)"  data-status=3 data-leave_application_id="{{$leaveApplication->leave_application_id}}" class="btn-rounded remarksForLeave btn btn-danger btn-outline"><i class="ti-close text-danger m-r-5"></i> @lang('common.reject')</a> </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
       @if(count($notice) > 0)
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">@lang('common.notice_board')</h3>
                <hr>
                <div class="noticeBord">
                    @foreach($notice as $row)
                        @php
                            $noticeDate=strtotime($row->publish_date);
                        @endphp
                        <div class="comment-center p-t-10">
                            <div class="comment-body">
                                <div class="user-img"> <i style="font-size: 31px" class="icon-folder-alt text-danger"></i></div>
                                <div class="mail-contnet">
                                    <h5>{{ substr($row->title,0,70)}}..</h5><span class="time">Published Date: {{date(" d M Y ", $noticeDate)}}</span>
                                    <br/><span class="mail-desc">
                                    @lang('notice.pulished_by'): {{$row->createdBy->first_name}} {{$row->createdBy->last_name}}<br>
                                    @lang('notice.description'): {!!  substr($row->description,0,80)!!}..
                                </span>
                                    <a href="{{url('notice/'.$row->notice_id)}}" class="btn m-r-5 btn-rounded btn-outline btn-danger">@lang('common.read_more')</a> </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      @endif

    @if(count($warning) > 0)
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">@lang('warning.warning')</h3>
                <hr>
                <div class="warning">
                    @foreach($warning as $row)
                        @php
                            $warning_date = strtotime($row->warning_date);
                        @endphp
                        <div class="comment-center p-t-10">
                            <div class="comment-body">
                                <div class="user-img"> <i style="font-size: 31px" class="fa fa-exclamation-triangle text-danger"></i></div>
                                <div class="mail-contnet">
                                    <h5>{{ substr($row->subject,0,70)}}..</h5><span class="time">Warning Date: {{date(" d M Y ", $warning_date)}}</span>
                                    <br/><span class="mail-desc">
                                @lang('warning.waring_by'): {{$row->warningBy->first_name}} {{$row->warningBy->last_name}}<br>
                                @lang('warning.description'): {!!  substr($row->description,0,80)!!}..
                        </span>
                                    <a href="{{url('warning/'.$row->warning_id)}}" class="btn m-r-5 btn-rounded btn-outline btn-danger">@lang('common.read_more')</a> </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($terminationData)
        <div class="col-md-12 col-lg-6 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">@lang('menu.termination')</h3>
                <hr>
                <div class="terminationData">

                        @php
                            $notice_date = strtotime($terminationData->notice_date);
                            $termination_date = strtotime($terminationData->termination_date);
                        @endphp
                        <div class="comment-center p-t-10">
                            <div class="comment-body">
                                <div class="user-img"> <i style="font-size: 31px" class="fa fa-exclamation-triangle text-danger"></i></div>
                                <div class="mail-contnet">
                                    <h5>
                                        {{ substr($terminationData->subject,0,70)}}..</h5>
                                        <span class="time">Notice Date: {{date(" d M Y ", $notice_date)}}</span>
                                    <br>
                                        <span class="time">Termination Date: {{date(" d M Y ", $termination_date)}}</span>
                                    <br/><span class="mail-desc">
                                            @lang('termination.terminated_by'): {{$terminationData->terminateBy->first_name}} {{$terminationData->terminateBy->last_name}}<br>
                                            @lang('terminate.description'): {!!  substr($terminationData->description,0,80)!!}..
                                        </span>
                                    <a href="{{url('termination/'.$terminationData->termination_id)}}" class="btn m-r-5 btn-rounded btn-outline btn-danger">Read More</a> </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    @endif

    </div>

    <div class="row">
        <!-- up comming birthday  -->
     <div class="row">
          @if(count($upcoming_birtday) > 0)
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">@lang('dashboard.upcoming_birthday')</h3>
                    <hr>
                    <div class="leaveApplication">
                    @foreach($upcoming_birtday as $employee_birthdate)
                    <div class="comment-center p-t-10">
                        <div class="comment-body">
                            @if($employee_birthdate->photo !='')
                                <div class="user-img"> <img src="{!! asset('uploads/employeePhoto/'.$employee_birthdate->photo) !!}" alt="user" class="img-circle"></div>
                            @else
                                <div class="user-img"> <img src="{!! asset('admin_assets/img/default.png') !!}" alt="user" class="img-circle"></div>
                            @endif
                            <div class="mail-contnet" > 

                                @php 
                                   $date_of_birth = $employee_birthdate->date_of_birth;
                                   $separate_date = explode('-',$date_of_birth);

                                   $date_current_year = date('Y').'-'.$separate_date[1].'-'.$separate_date[2];

                                   $create_date = date_create($date_current_year);
                                @endphp
                             
                                <h5>{{ $employee_birthdate->first_name }} {{$employee_birthdate->last_name}}</h5><span class="time">{{ date_format(date_create($employee_birthdate->date_of_birth),"D dS F Y") }}</span> 
                                <br/>

                                <span class="mail-desc">
                                    @if($date_current_year == date('Y-m-d'))
                                      <b>Today is 
                                       @if($employee_birthdate->gender == 'Male')
                                        His @else 
                                        Her 
                                        @endif 
                                        Birtday Wish 
                                     @if($employee_birthdate->gender == 'Male')
                                          Him 
                                      @else Her 
                                      @endif</b>

                                    @else 
                                     
                                       Wish 
                                       @if($employee_birthdate->gender == 'Male')
                                        Him @else 
                                        Her 
                                        @endif
                                        on {{ date_format($create_date,"D dS F Y") }} 
                                        


                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        @endif 
     </div>
    </div>
    


</div>

@endsection


@section('page_scripts')
<link href="{!! asset('admin_assets/plugins/bower_components/news-Ticker-Plugin/css/site.css') !!}" rel="stylesheet" type="text/css" />
<script src="{!! asset('admin_assets/plugins/bower_components/news-Ticker-Plugin/scripts/jquery.bootstrap.newsbox.min.js') !!}"></script>

    <script type="text/javascript">
        (function() {

            $(".demo1").bootstrapNews({
                newsPerPage: 2,
                autoplay: true,
                pauseOnHover:true,
                direction: 'up',
                newsTickerInterval: 4000,
                onToDo: function () {
                    //console.log(this);
                }
            });

        })();


        $(document).on('click', '.remarksForLeave', function () {

            var actionTo = "{{ URL::to('approveOrRejectLeaveApplication') }}";
            var leave_application_id = $(this).attr('data-leave_application_id');
            var status = $(this).attr('data-status');

            if(status == 2){
                var statusText = "Are you want to approve leave application?";
                var btnColor = "#2cabe3";
            }else{
                var statusText = "Are you want to reject leave application?";
                var btnColor = "red";
            }

            swal({
                    title: "",
                    text: statusText,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: btnColor,
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    var token = '{{ csrf_token() }}';
                    if (isConfirm) {
                        $.ajax({
                            type: 'POST',
                            url:actionTo,
                            data: {leave_application_id:leave_application_id,status:status,_token:token},
                            success: function (data) {
                                if (data == 'approve') {
                                    swal({
                                            title: "Approved!",
                                            text: "Leave application approved.",
                                            type: "success"
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                $('.' + leave_application_id).fadeOut();
                                            }
                                        });

                                }else{
                                    swal({
                                            title: "Rejected!",
                                            text: "Leave application rejected.",
                                            type: "success"
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                $('.' + leave_application_id).fadeOut();
                                            }
                                        });
                                }
                            }

                        });
                    } else {
                        swal("Cancelled", "Your data is safe .", "error");
                    }
                });
            return false;

        });

    </script>
@endsection