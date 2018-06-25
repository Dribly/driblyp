<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Exceptions;

/**
 * Description of SensorNotFoundException
 *
 * @author toby
 */
class SensorNotFoundException extends \Exception{
    protected $sensorID;

    //put your code here
    public function construct($uid, $errorMessage, $code = null) {
        $this->sensorID = $uid;
        parent::__construct('Sensor ' . $this->sensorID.': ' . $errorMessage, $code);
    }

    public function getSensorID() {
        return $this->sensorID;
    }
}
