<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Defaultvalueforsensorgarden extends Migration {

    /**
     * Note this constructor works around an issue with enums and DBAL
     * https://stackoverflow.com/questions/33140860/laravel-5-1-unknown-database-type-enum-requested
     */
    public function __construct() {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('water_sensors', function (Blueprint $table) {
            $table->integer('garden')->nullable()->unsigned()->change();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        ; //not idempotent so I don't care
    }
}
