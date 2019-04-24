<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_caches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('latitude',9,6);
            $table->double('longitude',9,6);
            $table->dateTime('forecast_updated_date');
            $table->dateTime('forecast_hour');
            $table->string('precip_type');
            $table->float('precip_probability');
            $table->float('precip_intensity');
            $table->float('precip_intensity_error');
            $table->boolean('is_current')->default(false);
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
        Schema::dropIfExists('weather_caches');
    }
}
