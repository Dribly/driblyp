<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Tap;
use App\WaterSensor;

class AddNameToTap extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('taps', function (Blueprint $table) {
            $table->string('name', 20)->nullable();
        }); //
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->string('name', 20)->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
    }
}