<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportLastTapRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('taps', function (Blueprint $table) {
            $table->datetime('last_on_request')->nullable();
            $table->datetime('last_off_request')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['last_on_request']);
            $table->dropColumn(['last_off_request']);
        });
    }
}