<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmployeeEducationQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_education_qualification', function (Blueprint $table) {
            $table->increments('employee_education_qualification_id');
            $table->integer('employee_id')->unsigned();
            $table->string('institute',200);
            $table->string('board_university',200);
            $table->string('degree',200);
            $table->string('result',100)->nullable();
            $table->string('cgpa',50)->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE employee_education_qualification ADD passing_year YEAR NOT NULL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_education_qualification');
    }
}
