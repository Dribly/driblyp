<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Tap;
use App\WaterSensor;
class setDefaultNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        foreach (Tap::all() as $tap) {
            $tap->name= substr($tap->description,0,20);
            $tap->save();
        }
//throw new \Exception ('Iam debuggugb');
        foreach (WaterSensor::all() as $sensor) {
            $sensor->name = substr($sensor->description,0,20);
            $sensor->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}
