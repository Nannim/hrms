<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAttendanceApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendance_approve', function (Blueprint $table) {
            $table->increments('employee_attendance_approve_id');
            $table->integer('employee_id');
            $table->integer('finger_print_id');
            $table->date('date');
            $table->string('in_time');
            $table->string('out_time');
            $table->string('working_hour');
            $table->string('approve_working_hour');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('employee_attendance_approve');
    }
}
