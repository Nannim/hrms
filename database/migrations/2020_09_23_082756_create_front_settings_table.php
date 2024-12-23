<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_title');
            $table->text('home_page_big_title');
            $table->text('short_description');
            $table->string('service_title');
            $table->string('job_title');
            $table->string('about_us_image');
            $table->string('logo');
            $table->text('footer_text')->nullable();
            $table->text('about_us_description');
            $table->string('contact_website')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('counter_1_title');
            $table->integer('counter_1_value');
            $table->string('counter_2_title');
            $table->integer('counter_2_value');
            $table->string('counter_3_title');
            $table->integer('counter_3_value');
            $table->string('counter_4_title');
            $table->integer('counter_4_value');
            $table->tinyInteger('show_job')->default(1)->nullable();
            $table->tinyInteger('show_service')->default(1)->nullable();
            $table->tinyInteger('show_about')->default(1)->nullable();
            $table->tinyInteger('show_contact')->default(1)->nullable();
            $table->tinyInteger('show_counter')->default(1)->nullable();
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
        Schema::dropIfExists('front_settings');
    }
}
