<?php

namespace App\Http\Controllers\User;

use App\Model\EmployeeEducationQualification;

use App\Repositories\AttendanceRepository;

use App\Http\Controllers\Controller;

use App\Model\EmployeePerformance;

use Illuminate\Support\Facades\DB;

use App\Model\EmployeeExperience;

use App\Model\LeaveApplication;

use App\Model\EmployeeAward;
use App\Model\EmployeeAttendance;

use Illuminate\Http\Request;

use App\Model\Termination;

use App\Model\Department;

use App\Model\Employee;

use App\Model\Warning;

use App\Model\Notice;
use App\Model\IpSetting;

use Mail;


class HomeController extends Controller
{

    protected $employeePerformance,$leaveApplication,$notice,$employeeExperience,$department,$employee,$employeeAward,$attendanceRepository,$warning,$termination;

    function __construct(
                        EmployeePerformance $employeePerformance,
                        LeaveApplication $leaveApplication,
                        Notice $notice,EmployeeExperience
                        $employeeExperience,Department
                        $department,Employee $employee,EmployeeAward
                        $employeeAward,AttendanceRepository $attendanceRepository,
                        Warning $warning,Termination $termination
                     )
    {
        $this->employeePerformance  = $employeePerformance;
        $this->leaveApplication     = $leaveApplication;
        $this->notice               = $notice;
        $this->employeeExperience   = $employeeExperience;
        $this->department           = $department;
        $this->employee             = $employee;
        $this->employeeAward        = $employeeAward;
        $this->attendanceRepository = $attendanceRepository;
        $this->warning              = $warning;
        $this->termination          = $termination;
    }


    public function index()
    {
        $ip_setting = IpSetting::orderBy('id','desc')->first();
        $ip_attendance_status = 0;
        $ip_check_status = 0;
        $login_employee = employeeInfo();
        $count_user_login_today = EmployeeAttendance::where('finger_print_id','=',$login_employee[0]->finger_id)->whereDate('in_out_time', '=', date('Y-m-d'))->count();

        if ($ip_setting) {
           
           // if 0 then attendance will not take 
           $ip_attendance_status = $ip_setting->status; 

           // if 0 then ip will not checked for attendance  
           
           $ip_check_status = $ip_setting->ip_status;

        }

        if(session('logged_session_data.role_id') != 1){

            $attendanceData = $this->attendanceRepository->getEmployeeMonthlyAttendance( date("Y-m-01"),date("Y-m-d"),session('logged_session_data.employee_id'));

            $employeePerformance =  $this->employeePerformance->select('employee_performance.*',DB::raw('AVG(employee_performance_details.rating) as rating'))
                ->with(['employee'=>function($d){
                    $d->with('department');
                }])
                ->join('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
                ->where('month', function($query){
                    $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
                })->where('employee_performance.status',1)->groupBy('employee_id')->get();

            $employeeTotalAward = $this->employeeAward
                                 ->select(DB::raw('count(*) as totalAward'))
                                 ->where('employee_id',session('logged_session_data.employee_id'))
                                 ->whereBetween('month',[date("Y-01"),date("Y-12")])
                                 ->first();

            $notice = $this->notice->with('createdBy')->orderBy('notice_id','DESC')->where('status','Published')->get();

            $terminationData = $this->termination->with('terminateBy')->where('terminate_to',session('logged_session_data.employee_id'))->first();

            $hasSupervisorWiseEmployee       = $this->employee->select('employee_id')->where('supervisor_id',session('logged_session_data.employee_id'))->get()->toArray();
            if(count($hasSupervisorWiseEmployee) == 0 ){
                $leaveApplication = [];
            }else {
                $leaveApplication  = $this->leaveApplication->with(['employee','leaveType'])
                    ->whereIn('employee_id',array_values($hasSupervisorWiseEmployee))
                    ->where('status',1)
                    ->orderBy('status','asc')
                    ->orderBy('leave_application_id','desc')
                    ->get();
            }

            $employeeInfo = $this->employee->with('designation')->where('employee_id',session('logged_session_data.employee_id'))->first();


            $employeeTotalLeave = $this->leaveApplication->select(DB::raw('IFNULL(SUM(number_of_day), 0) as totalNumberOfDays'))
                                ->where('employee_id',session('logged_session_data.employee_id'))
                                ->where('status',2)
                                ->whereBetween('approve_date',[date("Y-01-01"),date("Y-12-31")])
                                ->first();

            $warning = $this->warning->with(['warningBy'])->where('warning_to',session('logged_session_data.employee_id'))->get();

            // date of birth in this month 

        $firstDayThisMonth = date('Y-m-d');
        $lastDayThisMonth  = date("Y-m-d", strtotime("+1 month", strtotime($firstDayThisMonth)));

        $from_date_explode = explode('-', $firstDayThisMonth);
        $from_day = $from_date_explode[2];
        $from_month = $from_date_explode[1];
        $concatFormDayAndMonth = $from_month.'-'.$from_day;

        $to_date_explode = explode('-', $lastDayThisMonth);
        $to_day = $to_date_explode[2];
        $to_month = $to_date_explode[1];
        $concatToDayAndMonth = $to_month.'-'.$to_day;

         $upcoming_birtday =  Employee::orderBy('date_of_birth','desc')->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= '".$concatFormDayAndMonth."' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '".$concatToDayAndMonth."' ")->get();
            

            $data = [
                'attendanceData'          => $attendanceData,
                'employeePerformance'     => $employeePerformance,
                'employeeTotalAward'      => $employeeTotalAward,
                'notice'                  => $notice,
                'leaveApplication'        => $leaveApplication,
                'employeeInfo'            => $employeeInfo,
                'employeeTotalLeave'      => $employeeTotalLeave,
                'warning'                 => $warning,
                'terminationData'         => $terminationData,
                'upcoming_birtday'        => $upcoming_birtday,
                'ip_attendance_status'    => $ip_attendance_status,
                'ip_check_status'         => $ip_check_status,
                'count_user_login_today'  => $count_user_login_today
            ];

            return view('admin.generalUserHome',$data);
        }


        $hasSupervisorWiseEmployee       = $this->employee->select('employee_id')->where('supervisor_id',session('logged_session_data.employee_id'))->get()->toArray();
        if(count($hasSupervisorWiseEmployee) == 0 ){
            $leaveApplication = [];
        }else {
            $leaveApplication  = $this->leaveApplication->with(['employee','leaveType'])
                ->whereIn('employee_id',array_values($hasSupervisorWiseEmployee))
                ->where('status',1)
                ->orderBy('status','asc')
                ->orderBy('leave_application_id','desc')
                ->get();
        }

        $date            = date('Y-m-d');
        $attendanceData  = DB::select("call `SP_DailyAttendance`('".$date."')");
        $totalEmployee   = $this->employee->where('status',1)->count();
        $totalDepartment = $this->department->count();

        $employeePerformance =  $this->employeePerformance->select('employee_performance.*',DB::raw('AVG(employee_performance_details.rating) as rating'))
                                ->with(['employee'=>function($d){
                                    $d->with('department');
                                }])
                                ->join('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
                                ->where('month', function($query){
                                    $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
                                })->where('employee_performance.status',1)->groupBy('employee_id')->get();

        $employeeAward = $this->employeeAward->with(['employee'=>function($d){
                            $d->with('department');
                        }])->limit(10)->orderBy('employee_award_id','DESC')->get();

        $notice = $this->notice->with('createdBy')->orderBy('notice_id','DESC')->where('status','Published')->get();

         
               // date of birth in this month 

        $firstDayThisMonth = date('Y-m-d');
        $lastDayThisMonth  = date("Y-m-d", strtotime("+1 month", strtotime($firstDayThisMonth)));

        $from_date_explode = explode('-', $firstDayThisMonth);
        $from_day = $from_date_explode[2];
        $from_month = $from_date_explode[1];
        $concatFormDayAndMonth = $from_month.'-'.$from_day;

        $to_date_explode = explode('-', $lastDayThisMonth);
        $to_day = $to_date_explode[2];
        $to_month = $to_date_explode[1];
        $concatToDayAndMonth = $to_month.'-'.$to_day;

         $upcoming_birtday =  Employee::orderBy('date_of_birth','desc')->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= '".$concatFormDayAndMonth."' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '".$concatToDayAndMonth."' ")->get();

        $data = [
            'attendanceData'    =>$attendanceData,
            'totalEmployee'     =>$totalEmployee,
            'totalDepartment'   =>$totalDepartment,
            'totalAttendance'   =>count($attendanceData),
            'totalAbsent'       =>$totalEmployee - count($attendanceData),
            'employeePerformance'  =>$employeePerformance,
            'employeeAward'     =>$employeeAward,
            'notice'            =>  $notice,
            'leaveApplication'  =>  $leaveApplication,
            'upcoming_birtday'  =>  $upcoming_birtday,
            'ip_attendance_status'    => $ip_attendance_status,
            'ip_check_status'         => $ip_check_status,
            'count_user_login_today'  => $count_user_login_today

        ];


        return view('admin.adminhome',$data);
    }


    public function profile()
    {
        $employeeInfo       = Employee::where('employee.employee_id',session('logged_session_data.employee_id'))->first();
        $employeeExperience = EmployeeExperience::where('employee_id',session('logged_session_data.employee_id'))->get();
        $employeeEducation  = EmployeeEducationQualification::where('employee_id',session('logged_session_data.employee_id'))->get();

         return view('admin.user.user.profile',['employeeInfo'=>$employeeInfo,'employeeExperience'=>$employeeExperience,'employeeEducation'=>$employeeEducation]);
    }


    public function mail()
    {

        $user = array(
            'name' => "Learning Laravel",
        );

        Mail::send('emails.mailExample', $user, function($message){
            $message->to("kamrultouhidsak@gmail.com");
            $message->subject('E-Mail Example');
        });

        return "Your email has been sent successfully";
    }
}
