<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Model\LeaveApplication;

use App\Model\EarnLeaveRule;

use App\Model\LeaveType;

use App\Model\Employee;


class LeaveRepository
{

    public function calculateTotalNumberOfLeaveDays($application_from_date,$application_to_date){

        $holidays  = DB::select(DB::raw('call SP_getHoliday("'. $application_from_date .'","'.$application_to_date .'")'));
        $public_holidays = [];
        foreach ($holidays as $holidays) {
            $start_date = $holidays->from_date;
            $end_date = $holidays->to_date;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $public_holidays[] = $start_date;
                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            }
        }

        $weeklyHolidays = DB::select(DB::raw('call SP_getWeeklyHoliday()'));
        $weeklyHolidayArray = [];
        foreach ($weeklyHolidays as $weeklyHoliday){
            $weeklyHolidayArray[]=$weeklyHoliday->day_name;
        }

        $target = strtotime($application_from_date);
        $countDay = 0;
        while ($target <= strtotime(date("Y-m-d", strtotime($application_to_date)))) {

            $value = date("Y-m-d", $target);
            $target += (60 * 60 * 24);

            //get weekly  holiday name
            $timestamp = strtotime($value);
            $dayName = date("l", $timestamp);

            //if not in holidays and not in weekly  holidays
            if (!in_array($value, $public_holidays) && !in_array($dayName,$weeklyHolidayArray)) {
                $countDay++;
            }
        }

        return $countDay;
    }



    public function calculateEmployeeLeaveBalance($leave_type_id,$employee_id){
        if($leave_type_id == 1){
            return $this->calculateEmployeeEarnLeave($leave_type_id,$employee_id);
        }else {
            $leaveType = LeaveType::where('leave_type_id', $leave_type_id)->first();
            $leaveBalance = DB::select(DB::raw('call SP_calculateEmployeeLeaveBalance(' . $employee_id . ',' . $leave_type_id . ')'));
            return $leaveType->num_of_day - $leaveBalance[0]->totalNumberOfDays;
        }
    }



    public function calculateEmployeeEarnLeave($leave_type_id,$employee_id,$action=false){

        $employeeInfo          = Employee::where('employee_id',$employee_id)->first();
        $joiningYearAndMonth   = explode('-',$employeeInfo->date_of_joining);

        $joiningYear    = $joiningYearAndMonth[0];
        $joiningMonth   = (int) $joiningYearAndMonth[1];

        $currentYear    = date("Y");
        $currentMonth   = (int) date("m");

        $totalMonth = 0;

        if($joiningYear == $currentYear){
            for($i = $joiningMonth;$i <= $currentMonth;$i++){
                $totalMonth +=1;
            }
        }else{
           for($i = 1;$i <= $currentMonth;$i++){
               $totalMonth +=1;
           }
        }


        $ifExpenseLeave = LeaveApplication::select(DB::raw('IFNULL(SUM(leave_application.number_of_day), 0) as number_of_day'))
                        ->where('employee_id',$employee_id)
                        ->where('leave_type_id',$leave_type_id)
                        ->where('status',2)
                        ->whereBetween('approve_date',[date("Y-01-01"),date("Y-12-31")])
                        ->first();

        $earnLeaveRule = EarnLeaveRule::first();


        if($action == 'getEarnLeaveBalanceAndExpenseBalance'){
            $totalNumberOfDays = $totalMonth * $earnLeaveRule->day_of_earn_leave;
            $data = [
                'totalEarnLeave' => round($totalMonth * $earnLeaveRule->day_of_earn_leave),
                'leaveConsume' => $ifExpenseLeave->number_of_day,
                'currentBalance' => round($totalNumberOfDays - $ifExpenseLeave->number_of_day),
            ];
            return $data;
        }

        $totalNumberOfDays = $totalMonth * $earnLeaveRule->day_of_earn_leave;
        return   round($totalNumberOfDays - $ifExpenseLeave->number_of_day);
    }

}
