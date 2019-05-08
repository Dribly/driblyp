<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase {

    public function testwater_sensors() {
        $sut = new User();
        $waterSensors = $sut->water_sensors();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\hasMany', $waterSensors);
        $this->assertSame('owner', $waterSensors->getForeignKeyName());
    }
    public function testwater_taps() {
        $sut = new User();
        $taps = $sut->taps();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\hasMany', $taps);
        $this->assertSame('owner', $taps->getForeignKeyName());
    }

    public function testGardens() {
        $sut = new User();
        $gardens = $sut->gardens();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\hasMany', $gardens);
        $this->assertSame('owner', $gardens->getForeignKeyName());
    }


}
