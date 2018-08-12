<?php
namespace App\Custom;

class DateTimeIso extends \DateTime {

    /**
     * Return Date in ISO8601 format
     *
     * @return String
     */
    public function toIso8601($date) {

        return $this->format($date, 'Y-m-d H:i');
    }

    /**
     * Return difference between $this and $now
     *
     * @param Datetime|String $now
     * @return DateInterval
     */
    public function diff($now = 'NOW') {
        if(!($now instanceOf DateTime)) {
            $now = new DateTime($now);
        }
        return parent::diff($now);
    }

    /**
     * Return Age in Years
     *
     * @param Datetime|String $now
     * @return Integer
     */
    public function getAge($now = 'NOW') {
        return $this->diff($now)->format('%y');
    }

}

?>
