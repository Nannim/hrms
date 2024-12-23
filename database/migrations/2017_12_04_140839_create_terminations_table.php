<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination', function (Blueprint $table) {
            $table->increments('termination_id');
            $table->integer('terminate_to')->unsigned();
            $table->integer('terminate_by')->unsigned();
            $table->string('termination_type');
            $table->string('subject');
            $table->date('notice_date');
            $table->date('termination_date');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('termination');
    }
}
