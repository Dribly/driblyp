<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThresholdToSensors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->integer('threshold')->unsigned()->default(50);
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->dropColumn(['threshold']);
        });
    }
}