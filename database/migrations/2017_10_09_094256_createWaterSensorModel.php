<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterSensorModel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('water_sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner')->unsigned();
            $table->integer('garden')->unsigned();
            $table->string('uid')->unique();
            $table->string('description');
            $table->enum('status', array('active', 'deleted', 'inactive'))->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('water_sensors');
    }
}
