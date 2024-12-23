<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendance', function (Blueprint $table) {
            $table->increments('employee_attendance_id');
            $table->integer('finger_print_id');
            $table->dateTime('in_out_time');
            $table->text('check_type')->nullable();
            $table->bigInteger('verify_code')->nullable();
            $table->text('sensor_id')->nullable();
            $table->text('Memoinfo')->nullable();
            $table->text('WorkCode')->nullable();
            $table->text('sn')->nullable();
            $table->integer('UserExtFmt')->nullable();
            $table->string('mechine_sl',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_attendance');
    }
}
