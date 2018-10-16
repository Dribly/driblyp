<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSlots extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tap_id')->unsigned();
            $table->tinyInteger('hour_start')->unsigned();
            $table->tinyInteger('day_of_week')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('time_slots');
    }
}
