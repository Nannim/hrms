<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;

Use Illuminate\Support\Facades\DB;

use App\Model\EmployeePerformance;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use Illuminate\Http\Request;

use App\Model\Employee;


class PerformanceReportController extends Controller
{

    public function performanceSummaryReport(Request $request)
    {
        $employeeList = Employee::where('status',1)->get();
        $results='';
        if($_POST) {

            $results = EmployeePerformance::select('employee_performance.*','employee.first_name','employee.last_name','department.department_name',DB::raw('AVG(rating) as avgRating'))
                        ->leftJoin('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
                        ->join('employee','employee.employee_id','=','employee_performance.employee_id')
                        ->join('department','department.department_id','=','employee.department_id')
                        ->where('employee_performance.employee_id',$request->employee_id)
                        ->where('employee_performance.status',1)
                        ->whereBetween('month',[$request->from_month,$request->to_month])
                        ->groupBy('employee_performance_details.employee_performance_id')
                        ->orderBy('month','ASC')
                        ->get();

        }

        $data = [
            'results'        => $results,
            'employeeList'   => $employeeList,
            'employeeList'   => $employeeList,
            'from_month'     =>$request->from_month,
            'to_month'       =>$request->to_month,
            'employee_id'   =>$request->employee_id,
        ];
        return view('admin.performance.report.summaryReport',$data);
    }


    public function downloadPerformanceSummaryReport(Request $request){

        $results = EmployeePerformance::select('employee_performance.*','employee.first_name','employee.last_name','department.department_name',DB::raw('AVG(rating) as avgRating'))
            ->leftJoin('employee_performance_details','employee_performance_details.employee_performance_id','=','employee_performance.employee_performance_id')
            ->join('employee','employee.employee_id','=','employee_performance.employee_id')
            ->join('department','department.department_id','=','employee.department_id')
            ->where('employee_performance.employee_id',$request->employee_id)
            ->where('employee_performance.status',1)
            ->whereBetween('month',[$request->from_month,$request->to_month])
            ->groupBy('employee_performance_details.employee_performance_id')
            ->orderBy('month','ASC')
            ->get();

        $printHead = PrintHeadSetting::first();

        $data = [
            'results'    => $results,
            'printHead'  => $printHead,
            'from_month' => $request->from_month,
            'to_month'   => $request->to_month,
        ];

        $pdf = PDF::loadView('admin.performance.report.pdf.summaryReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = ".employee-performance.pdf";
        return $pdf->download($pageName);
    }
	
}
