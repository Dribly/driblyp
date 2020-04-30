<?php

namespace Tests\Unit\App;

use App\Garden;
use App\Library\Services\WeatherService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GardenTest extends TestCase {
    /**
     *
     * @return void
     */
    public function testGetUrl() {
        $sut = new Garden();
        $sut->id = 4;
        $this->assertSame($_SERVER['APP_URL'] . '/gardens/4', $sut->getUrl());
    }

    public function testgetWeather()
    {
        $mockWeather = $this->getMockBuilder('\App\WeatherCache')->disableOriginalConstructor();
     $mockWeatherService = $this->getMockBuilder('WeatherService')->disableOriginalConstructor()->setMethods(['getPrecipitationForecast'])->getMock();
     $mockWeatherService->method('getPrecipitationForecast')->will($this->returnValue($mockWeather));
        $sut = $this->getMockBuilder('\App\Garden')->disableOriginalConstructor()->setMethods(['getWeatherService'])->getMock();
        $sut->method('getWeatherService')->will($this->returnValue($mockWeatherService));

        $this->assertSame($mockWeather, $sut->getWeather());

    }

}
