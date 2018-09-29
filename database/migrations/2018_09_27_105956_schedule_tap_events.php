<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleTapEvents extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('taps', function (Blueprint $table) {
            $table->datetime('next_event_scheduled')->nullable();
            $table->text('next_event')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['next_event_scheduled']);
            $table->dropColumn(['next_event']);
        });
    }
}