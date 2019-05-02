<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWeatherForecastAccuracy extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('weather_caches', function (Blueprint $table) {
            DB::statement('ALTER TABLE weather_caches MODIFY precip_probability double(9,6)');
            DB::statement('ALTER TABLE weather_caches MODIFY precip_intensity double(9,6)');
            DB::statement('ALTER TABLE weather_caches MODIFY precip_intensity_error double(9,6)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
