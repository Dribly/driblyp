<?php

namespace App\Library\Services;
/*
 * Sample response
 * */

class CurlWrapperService {
    protected $lastError;
    protected $curl;

    public function __construct($endpoint) {
        $this->lastError = null;
        $this->curl = curl_init($endpoint);
        curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 20);
        // these options allow us to read the error message sent by the API
        curl_setopt($this->curl, CURLOPT_FAILONERROR, false);
        curl_setopt($this->curl, CURLOPT_HTTP200ALIASES, range(400, 599));

        if (0 !== curl_errno($this->curl)) {
            $this->lastError = curl_error($this->curl);
        }
//        return $this->curl;
    }

    public function exec():string {
        return curl_exec($this->curl);
    }

    public function getErrNo() {
        return curl_errno($this->curl);
    }

    public function getError() {
        return curl_error($this->curl);
    }

    public function close() {
        return curl_close($this->curl);
    }
}
