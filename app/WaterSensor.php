<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterSensor extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'owner', 'uid', 'last_signal', 'last_signal_date',
        'remember_token', 'battery_level', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'owner'
    ];

    public function getUrl() {
        return route('sensors.show', ['id' => $this->id]);
    }
    /**
     * Determine if a sensor needs to be watered
     * @return bool
     */
    public function needsWater(): bool {
        // If the tap is expected to be on, then we only decide we don;t need water when
        // we hit a higher threshold
        if ($this->expected_state === 'on') {
            $needsWater = $this->last_reading < ($this->threshold + 15);
        } else {
            $needsWater = $this->last_reading < $this->threshold;
        }
        return $needsWater;
    }
    
    
    
        }
