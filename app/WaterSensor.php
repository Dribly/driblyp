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
}
