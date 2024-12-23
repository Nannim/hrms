<?php

namespace App\Http\Controllers\Attendance;

use App\Repositories\AttendanceRepository;

use App\Http\Controllers\Controller;

use App\Lib\Enumerations\UserStatus;

use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use Illuminate\Http\Request;

use App\Model\LeaveType;

use App\Model\Employee;

use DateTime;


class AttendanceReportController extends Controller
{

    protected $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository){
        $this->attendanceRepository = $attendanceRepository;
    }



    public function dailyAttendance(Request $request){
        $results = [];
        if($_POST){
          $results = $this->attendanceRepository->getEmployeeDailyAttendance($request->date);  
        }
        
        return view('admin.attendance.report.dailyAttendance',['results' => $results,'formData'=> $request->date]);
    }




    public function monthlyAttendance(Request $request){
        $employeeList = Employee::where('status',UserStatus::$ACTIVE)->get();
        $results = [];
        if($_POST) {
            $results = $this->attendanceRepository->getEmployeeMonthlyAttendance(dateConvertFormtoDB($request->from_date), dateConvertFormtoDB($request->to_date),$request->employee_id);
        }
        return view('admin.attendance.report.monthlyAttendance',['results' => $results,'employeeList' => $employeeList,'from_date'=>$request->from_date,'to_date'=>$request->to_date,'employee_id'=>$request->employee_id]);
    }



    public function myAttendanceReport(Request $request){
        $employeeList = Employee::where('status',UserStatus::$ACTIVE)->where('employee_id',session('logged_session_data.employee_id'))->get();
        $results=[];
        if($_POST) {
            $results = $this->attendanceRepository->getEmployeeMonthlyAttendance(dateConvertFormtoDB($request->from_date), dateConvertFormtoDB($request->to_date),session('logged_session_data.employee_id'));
        }else{
            $results = $this->attendanceRepository->getEmployeeMonthlyAttendance(date('Y-m-01'),date("Y-m-t", strtotime(date('Y-m-01'))),session('logged_session_data.employee_id'));
        }

        return view('admin.attendance.report.mySummaryReport',['results' => $results,'employeeList' => $employeeList,'from_date'=>$request->from_date,'to_date'=>$request->to_date,'employee_id'=>$request->employee_id]);
    }



    public function downloadDailyAttendance($date){
        $printHead = PrintHeadSetting::first();
      
        $results = $this->attendanceRepository->getEmployeeDailyAttendance($date);  
      

        $data = [
            'results'   => $results,
            'date'      => $date,
            'printHead' => $printHead,
        ];
        $pdf = PDF::loadView('admin.attendance.report.pdf.dailyAttendancePdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = $date."-attendance.pdf";
        return $pdf->download($pageName);
    }



    public function downloadMonthlyAttendance(Request $request){

        $employeeInfo    = Employee::with('department')->where('employee_id',$request->employee_id)->first();
        $printHead       = PrintHeadSetting::first();
        $results         = $this->attendanceRepository->getEmployeeMonthlyAttendance(dateConvertFormtoDB($request->from_date), dateConvertFormtoDB($request->to_date),$request->employee_id);

        $data = [
            'results'        => $results,
            'form_date'      => dateConvertFormtoDB($request->from_date),
            'to_date'        => dateConvertFormtoDB($request->to_date),
            'printHead'      => $printHead,
            'employee_name'  => $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name'=> $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.attendance.report.pdf.monthlyAttendancePdf',$data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("monthly-attendance.pdf");
    }



    public function downloadMyAttendance(Request $request){
        $employeeInfo   = Employee::with('department')->where('employee_id',$request->employee_id)->first();
        $printHead      = PrintHeadSetting::first();
        $results        = $this->attendanceRepository->getEmployeeMonthlyAttendance(dateConvertFormtoDB($request->from_date), dateConvertFormtoDB($request->to_date),$request->employee_id);
        $data = [
            'results'       => $results,
            'form_date'     => dateConvertFormtoDB($request->from_date),
            'to_date'       => dateConvertFormtoDB($request->to_date),
            'printHead'     => $printHead,
            'employee_name' => $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name' => $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.attendance.report.pdf.mySummaryReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("my-attendance.pdf");
    }



    public function attendanceSummaryReport(Request $request){
        if($request->month){
            $month = $request->month;
        }else{
            $month = date("Y-m");
        }

        $monthAndYear    = explode('-',$month);
        $month_data          = $monthAndYear[1];
        $dateObj        = DateTime::createFromFormat('!m', $month_data);
        $monthName      = $dateObj->format('F');

        $monthToDate   = findMonthToAllDate($month);
        $leaveType     = LeaveType::get();
        $result        = $this->attendanceRepository->findAttendanceSummaryReport($month);

        return view('admin.attendance.report.summaryReport',['results' => $result,'monthToDate' => $monthToDate,'month' => $month,'leaveTypes' => $leaveType,'monthName' => $monthName]);
    }


    public function downloadAttendanceSummaryReport($month){
        $printHead      = PrintHeadSetting::first();
        $monthToDate   = findMonthToAllDate($month);
        $leaveType     = LeaveType::get();
        $result        = $this->attendanceRepository->findAttendanceSummaryReport($month);

        $monthAndYear    = explode('-',$month);
        $month_data          = $monthAndYear[1];
        $dateObj        = DateTime::createFromFormat('!m', $month_data);
        $monthName      = $dateObj->format('F');

        $data = [
            'results'   => $result,
            'month'     => $month,
            'printHead' => $printHead,
            'monthToDate' => $monthToDate,
            'leaveTypes' => $leaveType,
            'monthName' => $monthName,
        ];
        $pdf = PDF::loadView('admin.attendance.report.pdf.attendanceSummaryReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("attendance-summaryReport.pdf");
    }


}
