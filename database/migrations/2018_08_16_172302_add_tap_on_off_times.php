<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTapOnOffTimes extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('taps', function (Blueprint $table) {
            $table->datetime('last_on')->nullable();
            $table->datetime('last_off')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['last_on']);
            $table->dropColumn(['last_off']);
        });
    }
}
