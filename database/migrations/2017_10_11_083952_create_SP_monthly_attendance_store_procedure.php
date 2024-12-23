<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSPMonthlyAttendanceStoreProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE SP_monthlyAttendance(
                    IN employeeId INT(10),
                    IN from_date DATE,
                    IN to_date DATE
        ) 
 BEGIN 
 
select employee.employee_id,CONCAT(COALESCE(employee.first_name,\'\'),\' \',COALESCE(employee.last_name,\'\')) AS fullName,department_name,
                        view_employee_in_out_data.finger_print_id,view_employee_in_out_data.date,view_employee_in_out_data.working_time,
                        DATE_FORMAT(view_employee_in_out_data.in_time,\'%h:%i %p\') AS in_time,DATE_FORMAT(view_employee_in_out_data.out_time,\'%h:%i %p\') AS out_time, 
		TIME_FORMAT( work_shift.late_count_time, \'%H:%i:%s\' ) as lateCountTime,
	(SELECT CASE WHEN DATE_FORMAT(MIN(view_employee_in_out_data.in_time),\'%H:%i:00\')  > lateCountTime
            THEN \'Yes\' 
            ELSE \'No\' END) AS  ifLate,
 
            (SELECT CASE WHEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),\'%H:%i:%s\')),work_shift.late_count_time)  > \'0\'
            THEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),\'%H:%i:%s\')),work_shift.late_count_time) 
            ELSE \'00:00:00\' END) AS  totalLateTime,
             TIMEDIFF((DATE_FORMAT(work_shift.`end_time`,\'%H:%i:%s\')),work_shift.`start_time`) AS workingHour
                        from employee
                        inner join view_employee_in_out_data on view_employee_in_out_data.finger_print_id = employee.finger_id
                        inner join department on department.department_id = employee.department_id
JOIN work_shift on work_shift.work_shift_id = employee.work_shift_id
                        where `status`=1 
                       AND `date` between from_date and to_date and employee_id=employeeId
                        GROUP BY view_employee_in_out_data.date,view_employee_in_out_data.`finger_print_id`;
   

 
 END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_monthlyAttendance');
    }
}
