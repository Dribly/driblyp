<?php

namespace App;

//use App\Library\Services\TimerManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class TimeSlotManager implements \Iterator {
    private $days;
    private $tapId;
    private static $daysOfWeeName = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    //
    public function __construct(int $tapId) {
        $this->initDays();
        $this->tapId = $tapId;
    }

    /** begin iterator methods */
    private $currentDay = 0;

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current() {
        return $this->days[$this->currentDay];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        $this->currentDay++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return $this->currentDay;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        // only 0 to 7
        return $this->currentDay >= 0 && $this->currentDay <= (count($this->days) - 1);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        $this->currentDay = 0;
    }

    /** end iterator methods */

    public function getNowDayNumber(): int {
        return (int) date('w');
    }

    public function getNowHour(): int {
        return (int) date('G');
    }

    public function isTimerBlocked(): bool {
        if (array_key_exists($this->getNowHour(), $this->days[$this->getNowDayNumber()])) {
            return ($this->days[$this->getNowDayNumber()][$this->getNowHour()]);
        } else {
            return false;
        }
    }


    /**
     * Destructively reinitiate the days
     */
    public function initDays(): bool {
        $this->days = [0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => []];
        $this->currentDay = 0;
        return true;
    }

    public function dumpDays() {
        return $this->days;
    }

    public static function getDayName(int $dayNum) {
        return self::$daysOfWeeName[$dayNum];
    }

    /**
     * Add a single block to the record
     * @param int $day
     * @param int $hourStart
     * @return bool
     */
    public function addBlock(int $day, int $hourStart): bool {
        $this->days[$day][$hourStart] = true;
        return true;
    }

    public function getSlotsByDay(): array {
        return $this->days;
    }

    public function load(): bool {
        $slots = $this->getSlots()->get();
        foreach ($slots as $slot) {
            $this->days[(int)$slot->day_of_week][(int)$slot->hour_start] = true;
        };
        return true;
    }

    /**
     * get all current slots for this tap
     * @return Collection
     */
    private function getSlots(): Builder {
        return TimeSlot::where('tap_id', $this->tapId);
    }

    /**
     * get all soft-deleted slots for this tap
     * @return Builder
     */
    private function getTrashedSlots(): Builder {
        return TimeSlot::onlyTrashed()->where('tap_id', $this->tapId);
    }

    public function toJSON() {
        $result = new \stdClass();
        $result->days = [];
        foreach ($this->days as $dayOfWeek => $hourStarts) {
            $result->days[$dayOfWeek] = [];
            foreach ($hourStarts as $hour => $value) {
                $result->days[$dayOfWeek][$hour] = $value;
            }
        }
        $res = json_encode($result);
        vaR_dump($res);
        die();
        return $res;
//    return '{\'a\'=>\b\'}';
    }

    /**
     * Store this record to database, trashing any previous blocks
     * @return bool
     */
    public function save(): bool {
        // First soft delete everything
        $this->getSlots()->delete();
        $success = true;
        $tap = Tap::find($this->tapId);
        foreach ($this->days as $dayOfWeek => $hourStarts) {
            foreach ($hourStarts as $hour => $thisistrue) {
                $timeSlot = new TimeSlot();
                $timeSlot->tap()->associate($tap);
                $timeSlot->day_of_week = $dayOfWeek;
                $timeSlot->hour_start = $hour;
                $success |= $timeSlot->save();
            }
        }
        // Just like a DB transaction
        if ($success) {
            // Force deletion of soft deleted items
            $this->getTrashedSlots()->forceDelete();
        } else {
            //delete new iktems
            $this->getSlots()->forceDelete();
            // then restore old ones;
            $this->getTrashedSlots()->restore();
        }
        return $success;
    }

}
