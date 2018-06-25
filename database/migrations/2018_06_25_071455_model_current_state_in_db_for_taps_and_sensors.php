<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModelCurrentStateInDbForTapsAndSensors extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->float('last_reading', 6,2)->nullable();
        }); //
        Schema::table('taps', function (Blueprint $table) {
            $table->enum('status', ['on','off','error','disconnected'])->default('off');
            $table->datetime('last_on')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->dropColumn(['last_reading']);
        });
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['status']);
            $table->dropColumn(['last_on']);
        });
    }
}
