<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_setting', function (Blueprint $table) {
            $table->increments('bonus_setting_id');
            $table->string('festival_name');
            $table->integer('percentage_of_bonus');
            $table->enum('bonus_type', ['Gross', 'Basic']);
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
        Schema::dropIfExists('bonus_setting');
    }
}
