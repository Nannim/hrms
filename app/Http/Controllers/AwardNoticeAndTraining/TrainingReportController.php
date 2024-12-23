<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use App\Model\TrainingType;

use Illuminate\Http\Request;

use App\Model\TrainingInfo;

use App\Model\Employee;



class TrainingReportController extends Controller
{


    public function employeeTrainingReport(Request $request)
    {
        $employeeList = Employee::where('status',1)->get();
        $data= [];

        if($request->employee_id){
            $data = $this->employeeTrainingDataFormat($request->employee_id);
        }

        return view('admin.training.report.employeeTrainingReport',['employeeList' => $employeeList,'results' => $data,'employee_id'=>$request->employee_id]);
    }



    public function employeeTrainingDataFormat($employee_id)
    {
        $trainingType = TrainingType::where('status',1)->get();
        $trainingInfo = TrainingInfo::where('employee_id',$employee_id)->get()->toArray();
        $arrayFormat = [];
        foreach ($trainingType as $value)
        {
            $temp = [];
            $hasData = array_search($value->training_type_id, array_column($trainingInfo, 'training_type_id'));
            if(gettype($hasData) == 'integer'){
                $temp['training_type_name'] = $value->training_type_name;
                $temp['action']             = "Yes";
                $temp['subject']            = $trainingInfo[$hasData]['subject'];
                $temp['start_date']         = $trainingInfo[$hasData]['start_date'];
                $temp['end_date']           = $trainingInfo[$hasData]['end_date'];
                $temp['certificate']        = $trainingInfo[$hasData]['certificate'];
            }else{
                $temp['training_type_name'] = $value->training_type_name;
                $temp['action']             = "No";
                $temp['subject']            = '';
                $temp['start_date']         = '';
                $temp['end_date']           = '';
                $temp['certificate']        = '';
            }
            $arrayFormat[] = $temp;
        }

        return $arrayFormat;
    }



    public function downloadTrainingReport(Request $request)
    {
        $employeeInfo    = Employee::with('department')->where('employee_id',$request->employee_id)->first();
        $results         = $this->employeeTrainingDataFormat($request->employee_id);
        $printHead       = PrintHeadSetting::first();

        $data = [
            'results'   => $results,
            'printHead' => $printHead,
            'employee_name' => $employeeInfo->first_name.' '.$employeeInfo->last_name,
            'department_name' => $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.training.report.pdf.employeeTrainingReportPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = "training.pdf";
        return $pdf->download($pageName);
    }


}
