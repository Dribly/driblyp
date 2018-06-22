<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TapControlledBySensor extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tap_controlled_by_sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tap_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->enum('status', array('active', 'deleted', 'inactive'))->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
