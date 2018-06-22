<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogObjectUid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('message_logs', function (Blueprint $table) {
            $table->text('device_uid')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('message_logs', function (Blueprint $table) {
            $table->dropColumn(['device_uid']);
        });
    }
}
