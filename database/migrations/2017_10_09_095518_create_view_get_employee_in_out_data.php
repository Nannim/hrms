<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewGetEmployeeInOutData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE VIEW view_employee_in_out_data as select
   employee_attendance.`employee_attendance_id`,`employee_attendance`.`finger_print_id` AS `finger_print_id`,
  min(`employee_attendance`.`in_out_time`) AS `in_time`,
  if((count(`employee_attendance`.`in_out_time`) > 1),max(`employee_attendance`.`in_out_time`),\'\') AS `out_time`,
  date_format(`employee_attendance`.`in_out_time`,\'%Y-%m-%d\') AS `date`,
  timediff(max(`employee_attendance`.`in_out_time`),min(`employee_attendance`.`in_out_time`)) AS `working_time`
from `employee_attendance`
group by date_format(`employee_attendance`.`in_out_time`,\'%Y-%m-%d\'),`employee_attendance`.`finger_print_id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS view_employee_in_out_data');
    }
}
