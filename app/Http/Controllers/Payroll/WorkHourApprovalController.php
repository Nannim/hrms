<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Model\EmployeeAttendanceApprove;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Department;
use App\Model\Employee;

class WorkHourApprovalController extends Controller
{


    public function create(){
        $departmentList = Department::get();
        return view('admin.payroll.workHourApprove.index',['departmentList'=>$departmentList]);
    }



    public function filter(Request $request)
    {
        $data           = dateConvertFormtoDB($request->get('date'));
        $department     = $request->get('department_id');
        $departmentList = Department::get();
        $ifApproveWorkHour  = json_decode(EmployeeAttendanceApprove::where('date',$data)->get()->toJson(),true);
        $result = Employee::select('employee.employee_id','employee.finger_id','employee.department_id','employee.hourly_salaries_id',
            DB::raw('CONCAT(COALESCE(employee.first_name,\'\'),\' \',COALESCE(employee.last_name,\'\')) as fullName'),

            DB::raw('(SELECT DATE_FORMAT(MIN(view_employee_in_out_data.in_time), \'%H:%i:%s\')  FROM view_employee_in_out_data
                                                             WHERE view_employee_in_out_data.date = "'.$data.'" AND view_employee_in_out_data.finger_print_id = employee.finger_id ) AS inTime'),

            DB::raw('(SELECT DATE_FORMAT(MAX(view_employee_in_out_data.out_time), \'%H:%i:%s\') FROM view_employee_in_out_data
                                                             WHERE view_employee_in_out_data.date =  "'.$data.'" AND view_employee_in_out_data.finger_print_id = employee.finger_id ) AS outTime'),
            DB::raw('(select TIMEDIFF(outTime, inTime) ) AS workingHour'))
            ->where('employee.department_id',$department)
            ->where('employee.status',1)
            ->whereNotNull('hourly_salaries_id')
            ->get()->toArray();

        $attendanceData = [];
        foreach ($result as $key => $v){
            $ifApprove = array_search($v['finger_id'], array_column($ifApproveWorkHour, 'finger_print_id'));
            if(gettype($ifApprove) == 'integer') {
                $v['approve_working_hour'] = $ifApproveWorkHour[$ifApprove]['approve_working_hour'];
            }else{
                $v['approve_working_hour'] = '00:00';
            }
            if($v['inTime'] !=''){
                $v['inTime'] = $v['inTime'];
            }else{
                $v['inTime'] = '00:00';
            }

            if($v['outTime'] !=''){
                $v['outTime'] = $v['outTime'];
            }else{
                $v['outTime'] = '00:00';
            }
            if($v['workingHour'] !=''){
                $v['workingHour'] = $v['workingHour'];
            }else{
                $v['workingHour'] = '00:00';
            }
            $attendanceData[$key] = $v;
        }
//        dd($attendanceData);
        return view('admin.payroll.workHourApprove.index',['departmentList'=>$departmentList,'attendanceData'=>$attendanceData]);
    }

    public function store(Request $request){
        $date = dateConvertFormtoDB($request->date);
        $count = count($request->in_time);
        $dataFormat = [];
        if(isset($request->in_time)) {
            for ($i=0; $i < $count; $i++) {
                if($request->status[$i] == 'approve'){
                    continue;
                }
                $dataFormat[$i] =[
                    'finger_print_id'       => $request->finger_print_id[$i],
                    'employee_id'           => $request->employee_id[$i],
                    'in_time'               => $request->in_time[$i],
                    'out_time'              => $request->out_time[$i],
                    'working_hour'          => $request->working_hour[$i],
                    'approve_working_hour'  => $request->hour[$i].":".$request->minutes[$i],
                    'date'                  => $date,
                    'created_by'            => Auth::user()->user_id,
                    'updated_by'            => Auth::user()->user_id,
                ];
            }
        }

        try{
            if(count($dataFormat) > 0) {
                EmployeeAttendanceApprove::insert($dataFormat);
            }
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug == 0){
            return redirect()->back()->with('success', 'Employee working hour approved.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }


    }

}
