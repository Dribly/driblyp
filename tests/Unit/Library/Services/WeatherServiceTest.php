<?php

namespace Tests\Unit;

use App\Library\Services\WeatherService;
use App\WeatherCache;
use App\Library\Services\CurlWrapperService;
use ReflectionMethod;
use stdClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherServiceTest extends TestCase {

    public function providermakeBaseUrl(): array {
        return [
            ['https://api.darksky.net/forecast/' . config('darksky.api.key') . '/-23.4234,44.4323', 'forecast', -23.4234, 44.4323],
            ['https://api.darksky.net/historic/' . config('darksky.api.key') . '/87.4234,1.4323', 'historic', 87.4234, 1.4323]
        ];
    }

    /**
     * @param string $expected
     * @param string $type
     * @param $lat
     * @param $lng
     * @dataProvider providermakeBaseUrl
     */
    public function testmakeBaseUrl(string $expected, string $type, $lat, $lng) {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->setMethods()->getMock();
        $method = new ReflectionMethod($sut, 'makeBaseUrl');
        $method->setAccessible(true);
        $this->assertSame($expected, $method->invoke($sut, $type, $lat, $lng));
    }

    public function providergetPrecipitationForecast(): array {
        $mockReturnObject = new stdClass();
        return [
            [0, 0, 4.332931, -12.462267, 4.33333, -12.44, ['a' => 'b'], $mockReturnObject, true],
            [1, 1, 4.332931, -12.462267, 4.33333, -12.44, ['a' => 'b'], $mockReturnObject, false]
        ];
    }

    /**
     * @param string $expected
     * @param float $lat
     * @param float $lng
     * @param array $opts
     * @param string $getResults
     * @dataProvider providergetPrecipitationForecast
     */
    public function testgetPrecipitationForecast(int $expectGetFromApiCount, int $expectCacheWeatherCount, float $expectedLatitude, float $expectedLongitude, float $lat, float $lng, array $opts, stdClass $getResults, bool $dataExistsInCache) {
        if ($dataExistsInCache) {
            $mockWeatherFromCache = $this->getMockBuilder('\App\WeatherCache')->disableOriginalConstructor()->setMethods(['save'])->getMock();
        } else {
            $mockWeatherFromCache = null;
        }
//        $mockWeatherFromCache->precip_intensity = $mockIntensity;
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->setMethods(['getFromApi', 'cacheWeather', 'getWeatherFromCache'])->getMock();
        $sut->expects($this->exactly($expectCacheWeatherCount))->method('cacheWeather')->with($expectedLatitude, $expectedLongitude, $getResults)->will($this->returnValue(true));
        $sut->expects($this->exactly($expectGetFromApiCount))->method('getFromApi')->will($this->returnValue($getResults));
        $sut->method('getWeatherFromCache')->will($this->returnValue($mockWeatherFromCache));

        $this->assertSame($mockWeatherFromCache, $sut->getPrecipitationForecast($lat, $lng, $opts));

    }

    public function providerformatQueryString(): array {
        return [
            ['', []],
            ['?moo=bar', ['moo' => 'bar']],
            ['?moo=bar&woof=9', ['moo' => 'bar', 'woof' => 9]]
        ];
    }

    /**
     * @param string $expected
     * @param array $opts
     * @dataProvider providerformatQueryString
     */
    public function testformatQueryString(string $expected, array $opts) {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->setMethods(['get'])->getMock();
//        $sut->expects($this->once())->method('get')->with( $lat, $lng, 'forecast', $opts)->will($this->returnValue($getResults));

        $this->assertSame($expected, $sut->formatQueryString($opts));

    }

    public function providergetFromApi(): array {
        $mockResult = new stdClass();
        return [
            ['bar', null, 4.4, 3.4, 'forecast', [], '{"moo":"bar"}', 0, 'no error'],
            ['bar', 'some error', 4.4, 3.4, 'forecast', [], '{"moo":"bar"}', 1, 'some error']
        ];
    }

    /**
     * @param string $expectedAttributeValue
     * @param float $lat
     * @param float $lng
     * @param string $type
     * @param array $opts
     * @param $expectedUrl
     * @param $execResult
     * @param $curlErrNoResult
     * @param $curlErrorResult
     * @dataProvider providergetFromApi
     */
    public function testgetFromApi(string $expectedAttributeValue, ?string $expextedExceptionMessage, float $lat, float $lng, string $type, array $opts, string $execResult, $curlErrNoResult, $curlErrorResult) {
        $mockCurl = $this->getMockBuilder('App\Library\Services\CurlWrapperService')->setMethods(['exec', 'getError', 'getErrNo', 'close'])->disableOriginalConstructor()->getMock();
        $mockCurl->expects($this->any())->method('getErrNo')->will($this->returnValue($curlErrNoResult));
        $mockCurl->expects($this->any())->method('getError')->will($this->returnValue($curlErrorResult));
        $mockCurl->expects($this->any())->method('close')->will($this->returnValue(null));
        $mockCurl->expects($this->once())->method('exec')->will($this->returnValue($execResult));
//        $sut->expects($this->once())->method('get')->will($this->returnValue($getDataReturnValue))->with(config('unleashed.api_id'), config('unleashed.api_key'), $expectedEndpoint, $expectedParams, $sut::FORMAT_JSON);

        $mockCurl->method('getError')->will($this->returnValue($curlErrorResult));
//        $mockCurl->method('')

        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->setMethods(['getCurl'])->getMock();
        $sut->method('getCurl')->will($this->returnValue($mockCurl));
        if (!is_null($expextedExceptionMessage)) {
            $this->expectExceptionMessage($expextedExceptionMessage);
        }

        $method = new ReflectionMethod($sut, 'getFromApi');
        $method->setAccessible(true);
//        $this->assertSame($expected, $method->invoke($sut, $type, $lat, $lng));
//        getNewWeatherCache
        $this->assertAttributeSame($expectedAttributeValue, 'moo', $method->invoke($sut, $lat, $lng, $type, $opts));
//        $mockCurl->method('exec')->will($this->returnValue($execResult));

    }

    public function testgetNewWeatherCache() {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->setMethods([])->getMock();
        $method = new ReflectionMethod($sut, 'getNewWeatherCache');
        $method->setAccessible(true);
        $weatherCache = $method->invoke($sut);
        $this->assertInstanceOf('\App\WeatherCache', $weatherCache);
        $this->assertFalse($weatherCache->exists);
    }

    public function providerroundLatLng(): array {
        return [
            [1.424525, -1.149247, 1.4, -1.4, 6.6],
            [1.424525, -1.428398, 1.424324, -1.444000001, 6.6],
            [1.424525, -1.428398, 1.424324, -1.45, 6.6],
            [-14.898162, 80.417463, -14.9, 80.4, 6.6],
            [51.520336, -0.0, 51.514069, -0.132166, 6.6],
            [51.460981, -0.185714, 51.481410, -0.177768, 6.6],
            [51.520336, -0.246015, 51.509599, -0.128121, 6.6], //charing cross
            [51.520336, -0.0, 51.513784, -0.127084, 6.6], // seven dials
            [51.520336, -0.0, 51.512276, -0.123457, 6.6], // covent garden apple store
            [51.520336, -0.0, 51.511995, -0.122702, 6.6], // covent garden building thing
            [51.464578, -0.0, 51.513784, -0.127084, 80.6], // seven dials
            [51.464578, -0.0, 51.512276, -0.123457, 80.6], // covent garden apple store
            [0.0, 89.982523, 0, 90, 6.6]
        ];
    }

    /**
     * @param float $expectedLat
     * @param float $expectedLng
     * @param float $latitude
     * @param float $longitude
     * @dataProvider providerroundLatLng
     */
    public function testroundLatLng(float $expectedLat, float $expectedLng, float $latitude, float $longitude, float $gridsize) {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->disableOriginalConstructor()->setMethods([])->getMock();
        $method = new ReflectionMethod($sut, 'roundLatLng');
        $method->setAccessible(true);
//        $weatherService = new WeatherService();
//        $this->assertSame($expected, $method->invoke($sut, $type, $lat, $lng));

        $rounded = $method->invoke($sut, $latitude, $longitude, $gridsize);
        $this->assertSame($expectedLat, $rounded['latitude']);
        $this->assertSame($expectedLng, $rounded['longitude']);

    }

    public function testgetCurl() {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->disableOriginalConstructor()->setMethods()->getMock();
        $this->assertInstanceOf('\App\Library\Services\CurlWrapperService', $sut->getCurl('http://nowhere.i.care.about.com'));
    }
//$weatherCache->latitude = $latitude;
//$weatherCache->longitude = $longitude;
//$weatherCache->forecast_updated_time = gmdate('Y-m-d H:i:s');
//$weatherCache->forecast_hour = gmdate('Y-m-d H:00:00', $weather->time);
//$weatherCache->is_now = true;
//$weatherCache->precip_type = $weather->precipType;
//$weatherCache->precip_probability = $weather->precipProbability;
//$weatherCache->precip_intensity = $weather->precipIntensity;
//$weatherCache->precip_intensity_error = $weather->precipIntensityError;
//$weatherCache->precip_probability = $weather->precipProbability;
    public function providerpopulateNewWeatherCacheFromData(): array {
        $mockWeatherData = " {
  \"latitude\": 51.44,
  \"longitude\": -0.3,
  \"currently\": {
    \"time\": 1554380885,
    \"precipIntensity\": 0.0052,
    \"precipIntensityError\": 0.0032,
    \"precipProbability\": 0.7,
    \"precipType\": \"rain\",
    \"temperature\": 49.24,
    \"apparentTemperature\": 43.58
    },
\"hourly\": {
    \"summary\": \"Drizzle stopping in 25 min.\",
    \"icon\": \"rain\",
    \"data\": [
      {
        \"time\": 1554380880,
        \"precipIntensity\": 0.005,
        \"precipIntensityError\": 0.003,
        \"precipProbability\": 0.68,
        \"precipType\": \"rain\",
        \"temperature\": 49.24,
        \"apparentTemperature\": 43.58
        
      }]
     }
     }";
        $mockWeatherData2 = " 
        {
            \"latitude\":51.460981,
            \"longitude\":-0.267807,
            \"timezone\":\"Europe/London\",
            \"currently\":{\"time\":1556095057,
            \"summary\":\"Clear\",
            \"icon\":\"clear-day\",
            \"nearestStormDistance\":27,
            \"nearestStormBearing\":150,
            \"precipIntensity\":0,
            \"precipProbability\":0,
            \"temperature\":62.38,
            \"apparentTemperature\":62.38,
            \"dewPoint\":49.49,
            \"humidity\":0.63,
            \"pressure\":992.28,
            \"windSpeed\":7.3,
            \"windGust\":17.48,
            \"windBearing\":125,
            \"cloudCover\":0.06,
            \"uvIndex\":2,
            \"visibility\":4.48,
            \"ozone\":395.63
        },
        \"minutely\":
        {
            \"summary\":\"Clear for the hour.\",
            \"icon\":\"clear-day\",
            \"data\":[
            {
                 \"time\":1556095020,
                \"precipIntensity\":0,
                \"precipProbability\":0
            },
            {
                \"time\":1556097540,
                \"precipIntensity\":0.006,
                \"precipIntensityError\":0.003,
                \"precipProbability\":0.01,
                \"precipType\":\"rain\"
            }]
        },
        \"hourly\":
        {
            \"summary\":\"Mostly cloudy starting this afternoon.\",
            \"icon\":\"partly-cloudy-night\",
            \"data\":[
            {
                \"time\":1556092800,
                \"summary\":\"Clear\",
                \"icon\":\"clear-day\",
                \"precipIntensity\":0,
                \"precipProbability\":0,
                \"temperature\":60.4,
                \"apparentTemperature\":60.4,
                \"dewPoint\":49.15,
                \"humidity\":0.66,
                \"pressure\":992.32,
                \"windSpeed\":6.1,
                \"windGust\":15.39,
                \"windBearing\":115,
                \"cloudCover\":0.16,
                \"uvIndex\":1,
                \"visibility\":3.75,
                \"ozone\":396.23
            },
            {
                \"time\":" . time() . ",
                \"summary\":\"Clear\",
                \"icon\":\"clear-day\",
                \"precipIntensity\":0.0012,
                \"precipProbability\":0.1,
                \"precipType\":\"rain\",
                \"temperature\":63.56,
                \"apparentTemperature\":63.56,
                \"dewPoint\":49.65,
                \"humidity\":0.61,
                \"pressure\":992.25,
                \"windSpeed\":8.09,
                \"windGust\":18.72,
                \"windBearing\":129,
                \"cloudCover\":0,
                \"uvIndex\":3,
                \"visibility\":4.92,
                \"ozone\":395.28
            }]
        }}";
        $mockWeather = json_decode($mockWeatherData);
        $mockWeather2 = json_decode($mockWeatherData2);
        $fieldMap = [
            'precipIntensity' => 'precip_intensity',
            'precipIntensityError' => 'precip_intensity_error',
            'precipProbability' => 'precip_probability',
            'precipType' => 'precip_type',
        ];
        $fieldMapReduced = [
            'precipIntensity' => 'precip_intensity',
            'precipProbability' => 'precip_probability'
        ];
        return [
            [-14.6655, 78.32423, false, $fieldMap, $mockWeather->currently, -14.6655, 78.32423],
            [78.32423, -14.6655, false, $fieldMap, $mockWeather->hourly->data[0], 78.32423, -14.6655],
            [78.32423, -14.6655, false, $fieldMapReduced, $mockWeather2->hourly->data[0], 78.32423, -14.6655],
            [78.32423, -14.6655, true, $fieldMapReduced, $mockWeather2->hourly->data[1], 78.32423, -14.6655]

        ];
    }

    /**
     * @param float $expectedLat
     * @param float $expectedLng
     * @param bool $expectIsNow
     * @param array $fieldsToCheck which fields on theweathercache map to which fields on the weather data
     * @param stdClass $mockWeather
     * @param $lat
     * @param $lng
     * @throws \ReflectionException
     * @dataProvider providerpopulateNewWeatherCacheFromData
     */
    public function testpopulateNewWeatherCacheFromData(float $expectedLat, float $expectedLng, bool $expectIsNow, array $fieldsToCheck, stdClass $mockWeather, $lat, $lng) {
        $mockWeatherCache = $this->getMockBuilder('\App\WeatherCache')->disableOriginalConstructor()->setMethods(['save'])->getMock();
        $mockWeatherCache->method('save')->will($this->returnValue(true));
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->disableOriginalConstructor()->setMethods(['getNewWeatherCache'])->getMock();
        $sut->method('getNewWeatherCache')->will($this->returnValue($mockWeatherCache));

        $method = new ReflectionMethod($sut, 'populateNewWeatherCacheFromData');
        $method->setAccessible(true);
        $weatherCache = $method->invoke($sut, $lat, $lng, $mockWeather);

        $this->assertInstanceOf('\App\WeatherCache', $weatherCache);

        foreach ($fieldsToCheck as $weatherField => $weatherCacheField) {
            $this->assertSame($mockWeather->{$weatherField}, $weatherCache->{$weatherCacheField});
        }
        $this->assertSame($expectedLat, $weatherCache->latitude);
        $this->assertSame($expectedLng, $weatherCache->longitude);
        $this->assertSame($expectIsNow, $weatherCache->is_current);

    }


    public function providercacheWeather(): array {
        $mockWeatherData = " {
  \"latitude\": 51.44,
  \"longitude\": -0.3,
  \"timezone\": \"Europe/London\",
  \"currently\": {
    \"time\": 1554380885,
    \"summary\": \"Drizzle\",
    \"icon\": \"rain\",
    \"nearestStormDistance\": 0,
    \"precipIntensity\": 0.0052,
    \"precipIntensityError\": 0.0032,
    \"precipProbability\": 0.7,
    \"precipType\": \"rain\",
    \"temperature\": 49.24,
    \"apparentTemperature\": 43.58,
    \"dewPoint\": 37.76,
    \"humidity\": 0.64,
    \"pressure\": 994.25,
    \"windSpeed\": 15.4,
    \"windGust\": 29.99,
    \"windBearing\": 173,
    \"cloudCover\": 0.56,
    \"uvIndex\": 2,
    \"visibility\": 8.77,
    \"ozone\": 458.41
  },
  \"hourly\": {
    \"summary\": \"Drizzle stopping in 25 min.\",
    \"icon\": \"rain\",
    \"data\": [
      {
        \"time\": 1554380880,
        \"precipIntensity\": 0.005,
        \"precipIntensityError\": 0.003,
        \"precipProbability\": 0.68,
        \"precipType\": \"rain\"
      }
      ]
      }
      }";
        $mockWeather = json_decode($mockWeatherData);

        return [
            [2, 51.460981 /*rounded latitude*/, -0.267807/*rounded longitude*/, $mockWeather]
        ];
    }

    /**
     * @param int $expectedpopulateNewWeatherCacheFromDataCount
     * @param float $expectedLatitude
     * @param float $expectedLongitude
     * @param stdClass $mockWeather
     * @dataProvider providercacheWeather
     */
    public function testcacheWeather(int $expectedpopulateNewWeatherCacheFromDataCount, float $expectedLatitude, float $expectedLongitude, stdClass $mockWeather) {
        $sut = $this->getMockBuilder('\App\Library\Services\WeatherService')->disableOriginalConstructor()->setMethods(['populateNewWeatherCacheFromData'])->getMock();
        $sut->expects($this->exactly($expectedpopulateNewWeatherCacheFromDataCount))->method('populateNewWeatherCacheFromData')->with($expectedLatitude, $expectedLongitude);

        $method = new ReflectionMethod($sut, 'cacheWeather');
        $method->setAccessible(true);
        $method->invoke($sut, $expectedLatitude, $expectedLongitude, $mockWeather);
    }

}
