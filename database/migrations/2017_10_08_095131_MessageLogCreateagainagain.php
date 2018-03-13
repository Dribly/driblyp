<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessageLogCreateagainagain extends Migration
{
    public function up()
    {
        Schema::dropIfExists('message_logs');
        Schema::create('message_logs', function (Blueprint $table) {
            $table->string('topic');
            $table->string('route');
            $table->string('message');
            $table->string('received');
            $table->string('attributes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_logs');
    }
}
