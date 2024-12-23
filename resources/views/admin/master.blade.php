<!DOCTYPE html>
<html lang="en">
@php
$front_setting = getFrontData();
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{!! asset('admin_assets/img/logo.png') !!}" type="image/x-icon"/>
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
    <!-- Menu CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{!! asset('admin_assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') !!}"
          rel="stylesheet">
    <!-- toast CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/toast-master/css/jquery.toast.css') !!}"
          rel="stylesheet">
    <!-- morris CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/morrisjs/morris.css') !!}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{!! asset('admin_assets/css/animate.css') !!}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{!! asset('admin_assets/css/style.css') !!}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{!! asset('admin_assets/css/colors/megna-dark.css') !!}" id="theme" rel="stylesheet">
    <!-- data table CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/datatables/jquery.dataTables.min.css') !!}"
          rel="stylesheet" type="text/css"/>

    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/datepicker/datepicker3.css') !!}">
    <!-- Daterange picker -->
    <link rel="stylesheet"
          href="{!! asset('admin_assets/plugins/bower_components/daterangepicker/daterangepicker-bs3.css') !!}">
    <!-- time picker-->
    <link rel="stylesheet"
          href="{!! asset('admin_assets/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') !!}">
    <!-- sweetalert-->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/sweetalert/sweetalert.css') !!}">
    <!-- select 2 -->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/select2/select2.min.css') !!}">
    <!-- toast CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/toast-master/css/jquery.toast.css') !!}"
          rel="stylesheet">
    <!-- Star Ratings -->
    <link href="{!! asset('admin_assets/plugins/bower_components/rateyo/jquery.rateyo.min.css') !!}" rel="stylesheet">


    <script src="{!! asset('admin_assets/plugins/bower_components/jquery/dist/jquery.min.js')!!}"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <script type="text/javascript">
        var base_url = "{{ url('/').'/' }}";
    </script>
    <style>
        /*for yellow bg*/

        .navbar-header {
            background: #222a48;
        }
        #side-menu li a {
            color: #fff;
            border-left: 0px solid #2f323e;
        }
        .top-left-part .dark-logo {
            display: block;

        }
        .tiMenu{
            color: #fff;
        }
        .sidebar {
            background: #27333e;;
            box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        }
        .hideMenu{
            color: #fff;
        }
        #side-menu ul > li > a.active {
            color: #EDDF10;
            font-weight: 400;
        }
        #side-menu ul > li > a:hover {
            color: #fff;
        }
        /*for yellow bg*/

        .bg-title .breadcrumb {
            background: 0 0;
            margin-bottom: 0;
            float: none;
            padding: 0;
            margin-bottom: 9px;
            font-weight: 700;
            color: #777;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            height: auto;
            margin-top: -6px;
            padding-left: 0;
            padding-right: 0;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px;
        }

        .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 8px 11px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 4px;
            right: 1px;
            width: 20px;
        }

        .breadcrumbColor a {
            color: #41b3f9 !important;
        }

        tr td {
            color: black !important;
        }

        .tr_header {
            background-color: #EDF1F5;
        }

        table.dataTable thead th, table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #e4e7ea;
        }

        .btnColor {
            color: #fff !important;
        }

        .validateRq {
            color: red;
        }

        .panel .panel-heading {
            border-radius: 0;
            font-weight: 500;
            font-size: 16px;
            padding: 10px 25px;
        }

        .btn_style {
            width: 106px;
        }

        .error {
            color: red;
        }


    </style>
</head>

<body class="fix-header" onload="addMenuClass()">
<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo" href="{{url('dashboard')}}">
                    <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img style="width: 75px;"
                                                          src="{{ url('uploads/front/'.$front_setting->logo) }}" alt="home"
                                                          class="dark-logo img-fluid img-responsive"/>
                    </b>
                    <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text-->
                     </span> </a>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i  class="ti-menu tiMenu"></i></a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" style="color:#fff"> {{ App::getLocale() }}
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <ul class="dropdown-menu mailbox animated bounceInDown">
                        <li>
                            <div class="drop-title">@lang('common.chose_a_language')</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <a href="{{ url('local/en') }}">

                                    <h5>English</h5>
                                </a>
                            </div>


                            <div class="message-center">
                                <a href="{{ url('local/es') }}" title="Spanish">

                                    <h5>Español</h5>
                                </a>
                            </div>

                            <div class="message-center">
                                <a href="{{ url('local/fr') }}" title="French">

                                    <h5>Française</h5>
                                </a>
                            </div>

                            <div class="message-center">
                                <a href="{{ url('local/th') }}" title="Thai">

                                    <h5>ไทย</h5>
                                </a>
                            </div>

                        </li>
                        <!-- <li>
                            <a class="text-center" href="javascript:void(0);"> <strong>@lang('common.see_all_languages')</strong> <i class="fa fa-angle-right"></i> </a>
                        </li> -->
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                {{--<li>
                    <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                        <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                </li>--}}
                <li class="dropdown">
                    <?php
$employeeInfo = employeeInfo();
if ($employeeInfo[0]->photo != '') {
    ?>
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{!! asset('uploads/employeePhoto/'.$employeeInfo[0]->photo) !!}" alt="user-img"
                                width="36" class="img-circle"><b
                                class="hidden-xs " style="color: #fff !important;">{!!   $employeeInfo[0]->user_name !!}</b><span class="caret"></span>
                    </a>
                    <?php } else {?>
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" width="36"
                                class="img-circle"><b class="hidden-xs" style="color: #fff !important; "><span class="hideMenu" style="color: #fff !important;">{!!   $employeeInfo[0]->user_name !!}</span></b><span
                                class="caret hideMenu"></span> </a>
                    <?php }?>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li><a href="{{url('profile')}}"><i class="ti-user"></i> @lang('common.my_profile')</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{url('changePassword')}}"><i class="ti-settings"></i> @lang('common.change_password')</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{URL::to('/logout')}}"><i class="fa fa-power-off"></i> @lang('common.logout')</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span>
                </h3></div>
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <?php if ($employeeInfo[0]->photo != '') {?>
                    <div><img src="{!! asset('uploads/employeePhoto/'.$employeeInfo[0]->photo) !!}" alt="user-img"
                              class="img-circle"></div>
                    <?php } else {?>
                    <div><img src="{!! asset('admin_assets/img/default.png') !!}" alt="user-img" class="img-circle">
                    </div>
                    <?php }?>
                    <a href="#" class="dropdown-toggle u-dropdown " data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false"><span class="hideMenu">{!!   $employeeInfo[0]->user_name !!}</span> </a>

                </div>
            </div>
            <ul class="nav" id="side-menu">
                <li><a href="{{ url('dashboard') }}" class="waves-effect"><i class="mdi mdi-home hideMenu"
                                                                             data-icon="v"></i> <span class="hide-menu hideMenu"> {{ __('menu.dashboard') }}  </span></a>
                </li>
                <?php
$sideMenu = showMenu();
$menuItem = '';

foreach ($sideMenu as $key => $value) {
    $menuItem .= '<li class="treeview waves-effect">
                                        <a href="javascript:void(0)" class="module">
                                            <i class="iconFontSize ' . $value['icon_class'] . ' hideMenu"></i> <span class="hide-menu hideMenu">&nbsp;' . __('menu' . '.' . str_replace(' ', '_', strtolower($value['name']))) . '<span class="fa arrow"></span></span>
                                        </a>';

    if ($value['sub_menu']) {
        $menuItem .= '<ul class="treeview-menu nav nav-second-level">';

        foreach ($value['sub_menu'] as $menu) {

            if ($menu['menu_url'] != '' || $menu['sub_menu']) {
                $menuItem .= '<li>
                            	<a href="' . ($menu['menu_url'] ? route($menu['menu_url']) : 'javascript:void(0)') . '">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hideMenu">' . __('menu' . '.' . str_replace(' ', '_', strtolower($menu['name']))) . '</span>'
                    . ($menu['sub_menu'] ? '<i class="fa arrow"></i>' : '') .
                    '</a>';
                if ($menu['sub_menu']) {

                    $menuItem .= '<ul class="treeview-menu nav nav-third-level">';

                    foreach ($menu['sub_menu'] as $subMenu) {
                        $menuItem .= '<li class="">
                                        <a class="hideMenu" href="' . ($subMenu['menu_url'] ? route($subMenu['menu_url']) : 'javascript:void(0)') . '"> <i class="fa fa-circle-o"></i> &nbsp;' . __('menu' . '.' . str_replace(' ', '_', strtolower($subMenu['name']))) . '</a>

                                    </li>';
                    }
                    $menuItem .= '</ul>';
                }
                $menuItem .= '</li>';
            }

        }

        $menuItem .= '</ul>';
    }

    $menuItem .= '</li>';
}
echo $menuItem;
?>

            </ul>
        </div>
    </div>


    <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center">
        {{date('Y')}} &copy; <strong><a href="https://queenscreation.com.ng" target="_blank">Queens Creation</a>
        </strong> - All rights reserved.
    </footer>
</div>

</div>
<!-- Bootstrap Core JavaScript -->

<script src="{!! asset('admin_assets/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{!! asset('admin_assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') !!}"></script>
<!--slimscroll JavaScript -->
<script src="{!! asset('admin_assets/js/jquery.slimscroll.js') !!}"></script>
<!--Wave Effects -->
<script src="{!! asset('admin_assets/js/waves.js') !!}"></script>
<!--Counter js -->
<script src="{!! asset('admin_assets/plugins/bower_components/waypoints/lib/jquery.waypoints.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/counterup/jquery.counterup.min.js') !!}"></script>
<!-- Sparkline chart JavaScript -->
<script src="{!! asset('admin_assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') !!}"></script>
<!-- Custom Theme JavaScript -->
<script src="{!! asset('admin_assets/js/custom.min.js') !!}"></script>
<script src="{!! asset('admin_assets/js/dashboard1.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/toast-master/js/jquery.toast.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/sweetalert/sweetalert-dev.js') !!}"></script>
<!-- bootstrap-datepicker -->
<script src="{!! asset('admin_assets/plugins/bower_components/datepicker/bootstrap-datepicker.js')!!}"></script>
<!--TIme picker js-->
<script src="{!! asset('admin_assets/plugins/bower_components/timepicker/bootstrap-timepicker.min.js')!!}"></script>
<!-- select2 -->
<script src="{!! asset('admin_assets/plugins/bower_components/select2/select2.full.min.js')!!}"></script>

<script src="{!! asset('admin_assets/plugins/bower_components/toast-master/js/jquery.toast.js')!!}"></script>
<script src="{!! asset('admin_assets/js/toastr.js')!!}"></script>

<!-- jquery-validator -->
<script type="text/javascript"
        src="{!! asset('admin_assets/plugins/bower_components/jquery-validator/jquery-validator.1.15.0.js')!!}"></script>
<script type="text/javascript"
        src="{!! asset('admin_assets/plugins/bower_components/jquery-validator/jquery-additional-method.1.15.0.min.js')!!}"></script>
<!-- Star Ratings -->
<script src="{!! asset('admin_assets/plugins/bower_components/rateyo/jquery.rateyo.js')!!}"></script>



<script>
    $(function () {
        $(".select2").select2();
        $('#myTable').DataTable({
            "ordering": false,
        });

    });

    function addMenuClass() {
        var segment3 = '{{ Request::segment(1) }}';
        var url = base_url + segment3;
        // var navItem = $(this).find("[href='" + url + "']");

        $('a[href="' + url + '"]').parents('.treeview-menu').addClass('collapse in');
        $('a[href="' + url + '"]').parents('.treeview-menu').parent().children('.module').addClass('active');
    }

    $(".alert-success").delay(2000).fadeOut("slow");
    //   $(".alert-danger").delay(2000).fadeOut("slow");
    $(document).on("focus", ".yearPicker", function () {
        $(this).datepicker({
            format: 'yyyy',
            minViewMode: 2
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
        });
    });
    $(document).on("focus", ".dateField", function () {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            clearBtn: true
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
        });
    });
    $(document).on("focus", ".timePicker", function () {
        $(this).timepicker({
            showInputs: false,
            minuteStep: 1
        });
    });
    $(".monthField").datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    }).on('changeDate', function (e) {
        $(this).datepicker('hide');
    });

    $(document).on('click', '.delete', function () {
        var actionTo = $(this).attr('href');
        var token = $(this).attr('data-token');
        var id = $(this).attr('data-id');
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: actionTo,
                        type: 'post',
                        data: {_method: 'delete', _token: token},
                        success: function (data) {
                            if (data == 'hasForeignKey') {
                                swal({
                                    title: "Oops!",
                                    text: "This data is used anywhere",
                                    type: "error"
                                });
                            } else if (data == 'success') {
                                swal({
                                        title: "Deleted!",
                                        text: "Your information delete successfully.",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $('.' + id).fadeOut();
                                        }
                                    });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: "Something Error Found !, Please try again.",
                                    type: "error"
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
@yield('page_scripts')

</body>

</html>
