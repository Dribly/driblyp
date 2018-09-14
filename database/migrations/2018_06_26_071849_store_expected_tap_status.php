<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoreExpectedTapStatus extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('taps', function (Blueprint $table) {
            $table->enum('expected_state', ['on','off'])->default('off');
            $table->enum('reported_state', ['on','off'])->default('off');
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('message_logs', function (Blueprint $table) {
            $table->dropColumn(['expected_state']);
            $table->dropColumn(['known_state']);
        });
    }
}
