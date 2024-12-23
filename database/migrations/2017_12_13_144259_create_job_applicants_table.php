<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applicant', function (Blueprint $table) {
            $table->increments('job_applicant_id');
            $table->integer('job_id')->unsigned();
            $table->string('applicant_name',100);
            $table->string('applicant_email',100);
            $table->integer('phone');
            $table->text('cover_letter');
            $table->string('attached_resume',200);
            $table->date('application_date');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('job_applicant');
    }
}
