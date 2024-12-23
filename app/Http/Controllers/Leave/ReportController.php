<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;

use App\Lib\Enumerations\LeaveStatus;

use App\Repositories\LeaveRepository;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use App\Model\LeaveApplication;

use Illuminate\Http\Request;

use App\Model\LeaveType;

use App\Model\Employee;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{


    protected $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository){
        $this->leaveRepository = $leaveRepository;
    }


    public function employeeLeaveReport(Request $request){
        $employeeList = Employee::where('status',1)->get();
        $results = [];
        if($_POST){
            $results = LeaveApplication::with(['employee','leaveType','approveBy'])
                        ->where('status',LeaveStatus::$APPROVE)
                        ->where('employee_id',$request->employee_id)
                        ->whereBetween('application_date',[dateConvertFormtoDB($request->from_date),dateConvertFormtoDB($request->to_date)])
                        ->orderBy('leave_application_id','DESC')
                        ->get();
        }
        return view('admin.leave.report.employeeLeaveReport',['results'=>$results,'employeeList'=>$employeeList,'employee_id'=>$request->employee_id,'from_date'=>$request->from_date,'to_date'=>$request->to_date   ]);
    }



    public function downloadLeaveReport(Request $request){

        $employeeInfo    = Employee::with('department')->where('employee_id',$request->employee_id)->first();
        $printHead       = PrintHeadSetting::first();
        $results         = LeaveApplication::with(['employee','leaveType','approveBy'])
                            ->where('status',LeaveStatus::$APPROVE)
                            ->where('employee_id',$request->employee_id)
                            ->whereBetween('application_date',[dateConvertFormtoDB($request->from_date),dateConvertFormtoDB($request->to_date)])
                            ->orderBy('leave_application_id','DESC')
                            ->get();
        $data = [
            'results'           =>  $results,
            'form_date'         =>  dateConvertFormtoDB($request->from_date),
            'to_date'           =>  dateConvertFormtoDB($request->to_date),
            'printHead'         =>  $printHead,
            'employee_name'     =>  $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name'   =>  $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.leave.report.pdf.employeeLeaveReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = $employeeInfo->first_name."-leave-report.pdf";
        return $pdf->download($pageName);
    }



    public function myLeaveReport(Request $request){
        $employeeList   = Employee::where('status',1)->where('employee_id',session('logged_session_data.employee_id'))->get();
        if($_POST) {
            $results = LeaveApplication::with(['employee', 'leaveType', 'approveBy'])
                        ->where('status', LeaveStatus::$APPROVE)
                        ->where('employee_id', session('logged_session_data.employee_id'))
                        ->whereBetween('application_date',[dateConvertFormtoDB($request->from_date),dateConvertFormtoDB($request->to_date)])
                        ->orderBy('leave_application_id', 'DESC')
                        ->get();
        }else{
            $results = LeaveApplication::with(['employee', 'leaveType', 'approveBy'])
                        ->where('status', LeaveStatus::$APPROVE)
                        ->where('employee_id', session('logged_session_data.employee_id'))
                        ->whereBetween('application_date',[date('Y-01-01'),date('Y-m-d')])
                        ->orderBy('leave_application_id', 'DESC')
                        ->get();
        }

        return view('admin.leave.report.myLeaveReport',['results'=>$results,'employeeList'=>$employeeList,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }



    public function downloadMyLeaveReport(Request $request){

        $employeeInfo    = Employee::with('department')->where('employee_id',session('logged_session_data.employee_id'))->first();
        $printHead       = PrintHeadSetting::first();
        $results         = LeaveApplication::with(['employee','leaveType','approveBy'])
                            ->where('status',LeaveStatus::$APPROVE)
                            ->where('employee_id',session('logged_session_data.employee_id'))
                            ->whereBetween('application_date',[dateConvertFormtoDB($request->from_date),dateConvertFormtoDB($request->to_date)])
                            ->orderBy('leave_application_id','DESC')
                            ->get();
        $data = [
            'results'           =>  $results,
            'form_date'         =>  dateConvertFormtoDB($request->from_date),
            'to_date'           =>  dateConvertFormtoDB($request->to_date),
            'printHead'         =>  $printHead,
            'employee_name'     =>  $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name'   =>  $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.leave.report.pdf.myLeaveReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = "my-leave-report.pdf";
        return $pdf->download($pageName);
    }



    public function summaryReport(Request $request){

        $employeeList   = Employee::where('status',1)->get();
        $result=[];
        if($_POST){
            $result  = $this->summaryReportDataFormat($request->employee_id);
        }
        $data =[
            'results'           =>  $result,
            'employeeList'      =>  $employeeList,
            'from_date'         =>  $request->from_date,
            'to_date'           =>  $request->to_date,
            'employee_id'       =>  $request->employee_id,
        ];

        return view('admin.leave.report.summaryReport',$data);
    }



    public function summaryReportDataFormat($employee_id){
        $leaveType                  = LeaveType::get();
        $employeeTotalLeaveDetails  = LeaveApplication::select('leave_application.*',DB::raw('SUM(leave_application.number_of_day) as leaveConsume'))
                                        ->where('employee_id',$employee_id)
                                        ->groupBy('leave_application.leave_type_id')
                                        ->get()->toArray();
        $arrayFormat = [];
        foreach ($leaveType as $value){
            if($value->leave_type_id == 1){
                $action = "getEarnLeaveBalanceAndExpenseBalance";
                $getNumberOfEarnLeave       = $this->leaveRepository->calculateEmployeeEarnLeave($value->leave_type_id,$employee_id,$action);
                $temp['num_of_day']         = $getNumberOfEarnLeave['totalEarnLeave'];
                $temp['leave_consume']      = $getNumberOfEarnLeave['leaveConsume'];
                $temp['current_balance']    = $getNumberOfEarnLeave['currentBalance'];

            }else{
                $temp['num_of_day']     = $value->num_of_day;
                $a = array_search($value->leave_type_id, array_column($employeeTotalLeaveDetails, 'leave_type_id'));
                if(gettype($a) == 'integer'){
                    $temp['leave_consume']      = $employeeTotalLeaveDetails[$a]['leaveConsume'];
                    $temp['current_balance']    = $value->num_of_day - $employeeTotalLeaveDetails[$a]['leaveConsume'];
                }else{
                    $temp['leave_consume']       = 0;
                    $temp['current_balance']     =  $value->num_of_day;
                }
            }
            $temp['leave_type_id']      = $value->leave_type_id;
            $temp['leave_type_name']    = $value->leave_type_name;
            $arrayFormat[] = $temp;
        }

        return $arrayFormat;
    }



    public function downloadSummaryReport(Request $request){

        $employeeInfo    = Employee::with('department')->where('employee_id',$request->employee_id)->first();
        $printHead       = PrintHeadSetting::first();

        $result  = $this->summaryReportDataFormat($request->employee_id);
        $data = [
            'results'           =>  $result,
            'form_date'         =>  dateConvertFormtoDB($request->from_date),
            'to_date'           =>  dateConvertFormtoDB($request->to_date),
            'printHead'         =>  $printHead,
            'employee_name'     =>  $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name'   =>  $employeeInfo->department->department_name,
        ];


        $pdf = PDF::loadView('admin.leave.report.pdf.summaryReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = $employeeInfo->first_name."-leave-summary-report.pdf";
        return $pdf->download($pageName);
    }




}
