<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updatetaps extends Migration {

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
        Schema::table('taps', function (Blueprint $table) {
            $table->text('last_signal')->nullable();
            $table->datetime('last_signal_date')->nullable();
            $table->float('last_battery_level')->nullable();
            // Update this one
            $table->integer('garden')->nullable()->unsigned()->change();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('taps', function (Blueprint $table) {
            $table->dropColumn(['last_signal']);
            $table->dropColumn(['last_signal_date']);
            $table->dropColumn(['last_battery_level']);
        });
    }
}
