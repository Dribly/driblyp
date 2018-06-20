<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apiuser extends Model {

    public function save(array $options = array()) {
        if (empty($this->id)) {
            $this->auth_token = string_random();
        }
        return parent::save($options);
    }
//
}
