<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_grade', function (Blueprint $table) {
            $table->increments('pay_grade_id');
            $table->string('pay_grade_name',150)->unique();
            $table->integer('gross_salary');
            $table->integer('percentage_of_basic');
            $table->integer('basic_salary');
            $table->integer('overtime_rate')->nullable();
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
        Schema::dropIfExists('pay_grade');
    }
}
