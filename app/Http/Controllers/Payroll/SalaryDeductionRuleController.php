<?php

namespace App\Http\Controllers\payroll;

use App\Model\SalaryDeductionForLateAttendance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class SalaryDeductionRuleController extends Controller
{

    public function index()
    {
        $data = SalaryDeductionForLateAttendance::first();
        return view('admin.payroll.setup.salaryDeductionRule',['data' => $data]);
    }



    public function updateSalaryDeductionRule(Request $request)
    {
        $input   = $request->all();
        $data = SalaryDeductionForLateAttendance::findOrFail($request->salary_deduction_for_late_attendance_id);

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return "success";
        }else {
            return "error";
        }
    }

}
