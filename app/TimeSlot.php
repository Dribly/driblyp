<?php

namespace App;

//use App\Tap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeSlot extends Model {
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function tap() {
        return $this->belongsTo('App\Tap');
    }

    public static function isBlockPresent(int $tapId, int $dayOfWeek, int $hourToStart) {
        return self::where('tap_id',$tapId)->where('day_of_week', $dayOfWeek)->where('hour_of_start', $hourToStart)->count() > 0;
    }

//    public function resetTapHours
}
