<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultStatusForGardens extends Migration
{
    /**
     * Note this constructor works around an issue with enums and DBAL
     * https://stackoverflow.com/questions/33140860/laravel-5-1-unknown-database-type-enum-requested
     */
    public function __construct() {
//        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement('ALTER TABLE gardens MODIFY status enum(\'active\', \'deleted\', \'inactive\') ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}