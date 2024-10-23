<?php

namespace App\Helper;

// Media file getter 
// return the full url of target media store in assets directory 
// Note:: should ever store media file under assets folder 

class MediaAsset {
    public static $baseUrl;

    function __construct() {
        // base url 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        self::$baseUrl = $protocol . "://" . $host;
    }


    // return media file full url 

    public static function assets($file) {
        // media file full url 
        $mediaUrl = self::$baseUrl . "/assets/" . $file;

        return $mediaUrl;
    }
}