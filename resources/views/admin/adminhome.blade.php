@extends('admin.master')
@section('content')
@section('title')
@lang('dashboard.dashboard')
@endsection
<style>
    .dash_image {

        width: 60px;
    }

    @if(count($attendanceData) > 3) tbody {
        display: block;
        height: 300px;
        overflow: auto;
    }

    thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    thead {
        width: calc(100% - 1em)
    }

    @endif @if(count($leaveApplication) >=1) .leaveApplication {
        overflow-x: hidden;
        height: 210px;
    }

    @endif @if(count($notice) >=1) .noticeBord {
        overflow-x: hidden;
        height: 210px;
    }

    @endif
</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title"> @lang('dashboard.total_employee') </h3>
                <ul class="list-inline two-part">
                    <li>
                        <img class="dash_image" src="{{ asset('admin_assets/img/employee.png') }}">
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">{{$totalEmployee}}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">@lang('dashboard.total_department')</h3>
                <ul class="list-inline two-part">
                    <li>
                        <img class="dash_image" src="{{ asset('admin_assets/img/department.png') }}">
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">{{$totalDepartment}}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">@lang('dashboard.total_present')</h3>
                <ul class="list-inline two-part">
                    <li>
                        <img class="dash_image" src="{{ asset('admin_assets/img/present.png') }}">
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">{{$totalAttendance}}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">@lang('dashboard.total_absent')</h3>
                <ul class="list-inline two-part">
                    <li>
                        <img class="dash_image" src="{{ asset('admin_assets/img/absent.png') }}">
                    </li>
                    <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="counter text-danger">{{$totalAbsent}}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading"> @lang('dashboard.today_attendance') </div>
                <div class="table-responsive">
                    <table class="table table-hover manage-u-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>@lang('dashboard.photo')</th>
                                <th>@lang('common.name')</th>
                                <th>@lang('dashboard.in_time')</th>
                                <th>@lang('dashboard.out_time')</th>
                                <th>@lang('dashboard.late')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($attendanceData) > 0)
                            {{$dailyAttendanceSl =null }}
                            @foreach($attendanceData as $dailyAttendance)
                            <tr>
                                <td class="text-center">{{ ++$dailyAttendanceSl }}</td>
                                <td>
                                    @if($dailyAttendance->photo != '')
                                    <img style=" width: 70px; " src="{!! asset('uploads/employeePhoto/'.$dailyAttendance->photo) !!}" alt="user-img" class="img-circle">
                                    @else
                                    <img style=" width: 70px; " src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle">
                                    @endif
                                </td>
                                <td>{{$dailyAttendance->fullName}}
                                    <br /><span class="text-muted">{{$dailyAttendance->department_name}}</span>
                                </td>
                                <td>{{$dailyAttendance->in_time}} </td>
                                <td>
                                    <?php
                                    if ($dailyAttendance->out_time != '') {
                                        echo $dailyAttendance->out_time;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if (date('H:i', strtotime($dailyAttendance->totalLateTime)) != '00:00') {
                                        echo "<b style='color: red;'>" . date('H:i', strtotime($dailyAttendance->totalLateTime)) . "</b>";
                                    } else {
                                        echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i></b>";
                                    }
                                    ?>

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
      


        @if(count($notice) > 0)
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title">@lang('dashboard.notice_board')</h3>
                <hr>
                <div class="noticeBord">
                    @foreach($notice as $row)
                    @php
                    $noticeDate=strtotime($row->publish_date);
                    @endphp
                    <div class="comment-center p-t-10">
                        <div class="comment-body">

                            <div class="user-img"><i style="font-size: 31px" class="fa fa-flag-checkered text-info"></i></div>



                            <div class="mail-contnet">
                                <h5 class="text-danger">{{ substr($row->title,0,70)}}..</h5><span class="time">Published Date: {{date(" d M Y ", $noticeDate)}}</span>
                                <br /><span class="mail-desc">
                                    @lang('notice.published_by'): {{$row->createdBy->first_name}} {{$row->createdBy->last_name}}<br>
                                    @lang('notice.description'): {!! substr($row->description,0,80)!!}..
                                </span>
                                <a href="{{url('notice/'.$row->notice_id)}}" class="btn m-r-5 btn-rounded btn-outline btn-info">@lang('common.read_more')</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if(count($upcoming_birtday) > 0)
        <div class="col-md-6">
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
                            <div class="mail-contnet">

                                @php
                                $date_of_birth = $employee_birthdate->date_of_birth;
                                $separate_date = explode('-',$date_of_birth);

                                $date_current_year = date('Y').'-'.$separate_date[1].'-'.$separate_date[2];

                                $create_date = date_create($date_current_year);
                                @endphp

                                <h5>{{ $employee_birthdate->first_name }} {{$employee_birthdate->last_name}}</h5><span class="time">{{ date_format(date_create($employee_birthdate->date_of_birth),"D dS F Y") }}</span>
                                <br />

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

        @if(count($leaveApplication) > 0)
        <div class="col-md-6">
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
                            <div class="mail-contnet">
                                @php
                                $d=strtotime($leaveApplication->created_at);
                                @endphp
                                <h5>{{$leaveApplication->employee->first_name}} {{$leaveApplication->employee->last_name}}</h5><span class="time">{{date(" d M Y h:i: a", $d)}}</span> <span class="label label-rouded label-info">PENDING</span>
                                <br /><span class="mail-desc" style="max-height: none">
                                    @lang('leave.leave_type') : {{$leaveApplication->leaveType->leave_type_name}}<br>
                                    @lang('leave.request_duration') : {{dateConvertDBtoForm($leaveApplication->application_from_date)}} To {{dateConvertDBtoForm($leaveApplication->application_to_date)}}<br>
                                    @lang('leave.number_of_day') : {{$leaveApplication->number_of_day}} <br>
                                    @lang('leave.purpose') : {{$leaveApplication->purpose}}
                                </span>

                                <a href="javacript:void(0)" data-status=2 data-leave_application_id="{{$leaveApplication->leave_application_id}}" class="btn remarksForLeave btn btn-rounded btn-success btn-outline m-r-5"><i class="ti-check text-success m-r-5"></i>@lang('common.approve')</a>
                                <a href="javacript:void(0)" data-status=3 data-leave_application_id="{{$leaveApplication->leave_application_id}}" class="btn-rounded remarksForLeave btn btn-danger btn-outline"><i class="ti-close text-danger m-r-5"></i>@lang('common.reject')</a> </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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
            pauseOnHover: true,
            direction: 'up',
            newsTickerInterval: 4000,
            onToDo: function() {
                //console.log(this);
            }
        });

    })();

    $(document).on('click', '.remarksForLeave', function() {

        var actionTo = "{{ URL::to('approveOrRejectLeaveApplication') }}";
        var leave_application_id = $(this).attr('data-leave_application_id');
        var status = $(this).attr('data-status');

        if (status == 2) {
            var statusText = "Are you want to approve leave application?";
            var btnColor = "#2cabe3";
        } else {
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
            function(isConfirm) {
                var token = '{{ csrf_token() }}';
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: actionTo,
                        data: {
                            leave_application_id: leave_application_id,
                            status: status,
                            _token: token
                        },
                        success: function(data) {
                            if (data == 'approve') {
                                swal({
                                        title: "Approved!",
                                        text: "Leave application approved.",
                                        type: "success"
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            $('.' + leave_application_id).fadeOut();
                                        }
                                    });

                            } else {
                                swal({
                                        title: "Rejected!",
                                        text: "Leave application rejected.",
                                        type: "success"
                                    },
                                    function(isConfirm) {
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