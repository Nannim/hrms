<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KeyContstraintsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('user', function ($table) {
            $table->foreign('role_id')->references('role_id')->on('role');
        });
        Schema::table('employee', function ($table) {
            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('department_id')->references('department_id')->on('department');
            $table->foreign('designation_id')->references('designation_id')->on('designation');
            $table->foreign('branch_id')->references('branch_id')->on('branch');
            $table->foreign('work_shift_id')->references('work_shift_id')->on('work_shift');
        });
        Schema::table('holiday_details', function ($table) {
            $table->foreign('holiday_id')->references('holiday_id')->on('holiday');
        });
        Schema::table('leave_application', function ($table) {
            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('leave_type_id')->references('leave_type_id')->on('leave_type');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
