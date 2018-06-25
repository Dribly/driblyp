<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Exceptions;

/**
 * Description of TapNotFoundException
 *
 * @author toby
 */
class TapNotFoundException extends \Exception{
    protected $tapID;

    //put your code here
    public function construct($uid, $errorMessage, $code = null) {
        $this->tapID = $uid;
        parent::__construct('Tap ' . $this->tapID.': ' . $errorMessage, $code);
    }

    public function getTapID() {
        return $this->tapID;
    }
}
