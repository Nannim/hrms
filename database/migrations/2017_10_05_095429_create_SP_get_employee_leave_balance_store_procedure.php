<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSPGetEmployeeLeaveBalanceStoreProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        DB::unprepared('CREATE PROCEDURE SP_calculateEmployeeLeaveBalance( IN employeeId int(10),IN leaveTypeId int(10) )  BEGIN  
          SELECT SUM(number_of_day) AS totalNumberOfDays FROM leave_application WHERE employee_id=employeeId AND leave_type_id=leaveTypeId and status = 2
          AND (approve_date  BETWEEN DATE_FORMAT(NOW(),\'%Y-01-01\') AND DATE_FORMAT(NOW(),\'%Y-12-31\'));
         END');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_calculateEmployeeLeaveBalance');
    }
}
