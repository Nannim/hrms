<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSPGetHolidayStoreProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE SP_getHoliday(
IN fromDate DATE,
IN toDate DATE
) 
 BEGIN 
 
SELECT from_date,to_date FROM holiday_details WHERE from_date >= fromDate AND to_date <=toDate;
   

 
 END');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_getHoliday');
    }
}
