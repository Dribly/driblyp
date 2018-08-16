<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        /**
     * This function creates a message object that this controller will read later
     * @param string $deviceUid
     * @param array $message
     * @return \stdClass
     */
    public function makeMessage(string $deviceUid, array $message): \stdClass {
        $resultObj = new \stdClass();
        $resultObj->uid = $deviceUid;
        foreach ($message as $key => $value) {
            $resultObj->$key = $value;
        }
        return $resultObj;
    }
}
