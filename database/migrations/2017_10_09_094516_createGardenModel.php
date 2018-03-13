<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenModel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gardens', function (Blueprint $table) {
            $table->increments('id');
            $table->float('longitude');
            $table->float('latitude');
            $table->integer('owner')->unsigned();
            $table->string('description');
            $table->enum('status', array('deleted', 'inactive', 'active'));
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
        Schema::dropIfExists('gardens');
    }
}
