<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password','auth_token','password_reset_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','auth_token','password_reset_token'
    ];

    public function taps(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Tap', 'owner');
    }
    public function water_sensors(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\WaterSensor', 'owner');
    }
    public function gardens(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Garden', 'owner');
    }
}
