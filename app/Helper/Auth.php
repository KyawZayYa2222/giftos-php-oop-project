<?php
namespace App\Helper;

use App\Helper\User;

class Auth {
    private static $userInstance;

    public function __construct() {
        session_start();
    }

    
    // get authenicated user data 
    public static function user() {
        if(!isset($userInstance)) {
            self::$userInstance = unserialize($_SESSION['user']);
        }

        return self::$userInstance;
    }


    // Auth check 
    public static function check() {
        if(isset(self::$userInstance) || isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }


    // Auth make 
    public static function make(array $userData) {
        // create user object 
        $user = new User($userData);

        self::$userInstance = $user;

        // store in session 
        $_SESSION['user'] = serialize($user);

        return $user;
    }   
}