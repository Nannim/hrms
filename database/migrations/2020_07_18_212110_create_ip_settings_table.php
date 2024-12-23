<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip_address')->nullable();
            $table->tinyInteger('ip_status')->default(0)->comment = "0 = not checking it 1 = checking ip";
            $table->tinyInteger('status')->comment = "0 = not providing employee self attendance 1 = providing";
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
        Schema::dropIfExists('ip_settings');
    }
}
