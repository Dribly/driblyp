<?php

namespace App;

use App\Exceptions\GardenNotFoundException;
use App\Library\Services\WeatherService;
use Illuminate\Database\Eloquent\Model;

class Garden extends Model {
    public static function getGarden(int $ownerId, int $gardenID, string $uid = null): Garden {
// find by UID if presented
        if (!is_null($uid)) {
            $garden = Garden::where(['uid' => $uid, 'owner' => $ownerId])->first();
        } else {
            $garden = Garden::where(['id' => (int)$gardenID, 'owner' => $ownerId])->first();
        }
        if (!$garden instanceof Garden) {
            throw new GardenNotFoundException();
        }

        return $garden;
    }

    protected function getWeatherService() {
        return new WeatherService();
    }

    public function getWeather() {
        $weather = $this->getWeatherService();
        return $weather->getPrecipitationForecast($this->latitude, $this->longitude);
    }

    public function getUrl(): string {
        return route('gardens.show', ['id' => $this->id]);
    }
}
