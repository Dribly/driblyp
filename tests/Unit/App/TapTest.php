<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tap;
class TapTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testGetUrl()
    {
        $this->sut = new Tap();
        $this->sut->id = 4;
        $this->assertSame($_SERVER['APP_URL'].'/taps/4', $this->sut->getUrl());
    }
    
}
