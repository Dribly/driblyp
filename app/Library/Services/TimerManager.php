<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 08/10/2018
 * Time: 18:00
 */

namespace App\Library\Services;

use App\TimeSlotManager;

class TimerManager {

    public function getTimeSlots(int $tapId): TimeSlotManager {
        $collection = new TimeSlotManager($tapId);
        $collection->loadFromDatabase();
        return $collection;
    }

    /**
     * destructively resets the timeslots, erasing all from disk
     * @param TimeSlotManager $collection
     * @return bool
     */
    public function clearTimeSlots(TimeSlotManager $collection) {
        $collection->initDays();
        return $collection->saveToDatabase();
    }

    public function saveTimeSlots() {
    }

}