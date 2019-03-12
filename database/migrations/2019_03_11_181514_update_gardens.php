<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGardens extends Migration {
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
        Schema::table('gardens', function (Blueprint $table) {
            $table->renameColumn('description', 'name');
            $table->string('address')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('gardens', function (Blueprint $table) {
            $table->renameColumn('name', 'description');
            $table->dropColumn(['address']);
        });
    }
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
//public
//function down() {
//    Schema::table('taps', function (Blueprint $table) {
//        $table->dropColumn(['last_off']);
//    });
