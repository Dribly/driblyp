<?php

namespace App\Exceptions;

use Exception;

class GardenNotFoundException extends Exception {
    protected $gardenID;

    //put your code here
    public function construct($uid, $errorMessage, $code = null) {
        $this->gardenID = $uid;
        parent::__construct('Garden ' . $this->gardenID . ': ' . $errorMessage, $code);
    }

    public function getGardenID() {
        return $this->gardenID;
        //
    }
}
