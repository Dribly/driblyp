<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Exceptions;

/**
 * Description of InvalidMessageException
 *
 * @author toby
 */
class InvalidMessageException extends \Exception {

    protected $badMessage;

    //put your code here
    public function construct($original, $errorMessage, $code = null) {
        $this->badMessage = $original;
        parent::__construct($errorMessage, $code);
    }

    public function getBadMessage() {
        return $this->badMessage;
    }
}
