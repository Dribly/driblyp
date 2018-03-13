<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Sensor
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'owner', 'mfrid', 'lastsignal', 'batterylevel','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'owner'
    ];
}
