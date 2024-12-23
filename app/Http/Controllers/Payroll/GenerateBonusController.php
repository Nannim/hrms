<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;

use App\Lib\Enumerations\UserStatus;

use Illuminate\Support\Facades\DB;

use App\Model\EmployeeBonus;

use Illuminate\Http\Request;

use App\Model\BonusSetting;

use App\Model\Employee;

use App\Model\TaxRule;

use Carbon\Carbon;

use DateTime;


class GenerateBonusController extends Controller
{

    public function index() {
        $results = EmployeeBonus::with('employee.payGrade','employee.hourlySalaries','festivalName')->orderBy('employee_bonus_id','DESC')->get();
        return view('admin.payroll.generateBonus.index',['results' => $results]);
    }


    public function create() {
        $bonusList = BonusSetting::get();
        return view('admin.payroll.generateBonus.generateBonus',['bonusList' => $bonusList]);
    }


    public function filter(Request $request) {

        $employee_bonus =  EmployeeBonus::where('bonus_setting_id',$request->bonus_setting_id)->where('month',$request->month)->first();
        if($employee_bonus){
            return redirect('generateBonus/create')->with('error', 'The festival name and month has already been taken.');
        }
        $bonus_setting_id = $request->bonus_setting_id;
        $month            = $request->month;
        $bonusList        = BonusSetting::get();
        $bonusRule        = BonusSetting::where('bonus_setting_id',$bonus_setting_id)->first();
        $employee         = Employee::select(DB::raw('CONCAT(COALESCE(employee.first_name,\'\'),\' \',COALESCE(employee.last_name,\'\')) AS fullName'),'employee.date_of_birth',
                                'employee.gender','department.department_name','department.department_name','pay_grade.pay_grade_name','pay_grade.gross_salary','employee.employee_id',
                                'pay_grade.basic_salary','hourly_salaries.hourly_grade','hourly_salaries.hourly_rate','designation.designation_name')
                            ->join('department', 'department.department_id', '=', 'employee.department_id')
                            ->join('designation', 'designation.designation_id', '=', 'employee.designation_id')
                            ->leftJoin('pay_grade', 'pay_grade.pay_grade_id', '=', 'employee.pay_grade_id')
                            ->leftJoin('hourly_salaries', 'hourly_salaries.hourly_salaries_id', '=', 'employee.hourly_salaries_id')
                            ->where('permanent_status',UserStatus::$PERMANENT)
                            ->get()->toArray();

        $bonus_type          = $bonusRule->bonus_type;
        $percentage_of_bonus = $bonusRule->percentage_of_bonus;
        $data                = [];

        foreach ($employee as $key => $value){

            if($bonus_type == 'Basic'){
                if($value['pay_grade_name'] != ''){
                    $result  = $this->calculateEmployeeTax($value['basic_salary'],$percentage_of_bonus,$value['date_of_birth'],$value['gender']);
                    $value['tax'] = $result['tax'];
                    $value['net_bonus'] = $result['netBonus'];
                }else{
                    $workingDays = $this->number_of_working_days_date($month);
                    $totalSalary = ($workingDays * 8)  * $value['hourly_rate'];
                    $result  = $this->calculateEmployeeTax($totalSalary,$percentage_of_bonus,$value['date_of_birth'],$value['gender']);
                    $value['tax'] = $result['tax'];
                    $value['net_bonus'] = $result['netBonus'];
                }
            }else{
                if($value['pay_grade_name'] !='') {
                    $result = $this->calculateEmployeeTax($value['gross_salary'], $percentage_of_bonus, $value['date_of_birth'], $value['gender']);
                    $value['tax'] = $result['tax'];
                    $value['net_bonus'] = $result['netBonus'];
                }else{
                    $workingDays = $this->number_of_working_days_date($month);
                    $totalSalary = ($workingDays * 8)  * $value['hourly_rate'];
                    $result  = $this->calculateEmployeeTax($totalSalary,$percentage_of_bonus,$value['date_of_birth'],$value['gender']);
                    $value['tax'] = $result['tax'];
                    $value['net_bonus'] = $result['netBonus'];
                }
            }
            $data[$value['department_name']][] = $value;
        }

        return view('admin.payroll.generateBonus.generateBonus',['results'=>$data,'bonusList'=>$bonusList]);
    }


    public function calculateEmployeeTax($salary,$percentage_of_bonus,$date_of_birth,$gender) {
        $birthday   = $this->getEmployeeAge($date_of_birth);
        $tax        = 0;
        $totalTax   = ($salary * $percentage_of_bonus) / 100;
        $netBonus  = $totalTax;

        if($birthday >= 65 || $gender == 'Female'){
            $taxRule = TaxRule::where('gender','Female')->get();
        }else{
            $taxRule = TaxRule::where('gender','Male')->get();
        }

        foreach ($taxRule as $value){
            if($totalTax <= 0){
                break;
            }
            if($totalTax >= $value->amount && $value->amount !=0){
                $tax +=($value->amount * $value->percentage_of_tax) / 100;
                $totalTax = $totalTax -$value->amount;
            }else{
                $tax +=($totalTax * $value->percentage_of_tax) / 100;
                $totalTax = $totalTax - $totalTax;
            }
        }
        $data = [
            'netBonus' => $netBonus,
            'tax'      => $tax,
        ];
        return $data;
    }


    public function getEmployeeAge($date_of_birth) {
        $birthday = new DateTime ($date_of_birth);
        $currentDate = new DateTime ( 'now' );
        $interval = $birthday->diff ( $currentDate );
        return $interval->y;
    }


    public function number_of_working_days_date($month) {
        $date = findMonthToStartDateAndEndDate($month);
        $from_date = $date['start_date'];
        $to_date = $date['end_date'];
        $holidays  = DB::select(DB::raw('call SP_getHoliday("'. $from_date .'","'.$to_date.'")'));
        $public_holidays = [];
        foreach ($holidays as $holidays) {
            $start_date = $holidays->from_date;
            $end_date   = $holidays->to_date;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $public_holidays[] = $start_date;
                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            }
        }

        $weeklyHolidays = DB::select(DB::raw('call SP_getWeeklyHoliday()'));
        $weeklyHolidayArray = [];
        foreach ($weeklyHolidays as $weeklyHoliday){
            $weeklyHolidayArray[] = $weeklyHoliday->day_name;
        }

        $target = strtotime($from_date);
        $numberOfWorkingDays = 0 ;

        while ($target <= strtotime(date("Y-m-d", strtotime($to_date)))) {
            $timestamp  = strtotime(date('Y-m-d', $target));
            $dayName    = date("l", $timestamp);
            if(!in_array(date('Y-m-d', $target),$public_holidays) && !in_array($dayName,$weeklyHolidayArray)) {
                $numberOfWorkingDays ++;
            }
            $target += (60 * 60 * 24);
        }

        return $numberOfWorkingDays;
    }


    public function store(Request $request) {
        $count = count($request->employee_id);
        $dataFormat = [];
        for ($i = 0;$i < $count; $i++){
            $dataFormat[$i] =[
                'bonus_setting_id'  => $request->bonus_setting_id,
                'employee_id'       => $request->employee_id[$i],
                'month'             => $request->month,
                'gross_salary'      => $request->gross_salary[$i],
                'basic_salary'      => $request->basic_salary[$i],
                'bonus_amount'      => $request->bonus_amount[$i],
                'tax'               => $request->tax[$i],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ];
        }

        try{
            DB::beginTransaction();
                 EmployeeBonus::insert($dataFormat);
            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('generateBonus')->with('success', 'Employee bonus successfully saved.');
        }else {
            return redirect('generateBonus')->with('error', 'Something Error Found !, Please try again.');
        }
    }
}
