<?php

namespace App\Helper;

use Dotenv\Dotenv;


class DateTime {

    function __construct() {
        // load env 
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->setTimeZone();
    }


    // set time zone 
    private function setTimeZone() {
        date_default_timezone_set($_ENV['TIME_ZONE']);
    }
    

    // $format (string) 
    public function getDate($format) {
        return date($format);
    }
}