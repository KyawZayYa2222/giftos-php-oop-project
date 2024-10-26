<?php
namespace App\Helper;

use App\Helper\User;

class Auth {
    private static $userInstance;

    function __construct() {
        session_start();
    }

    // public function user() {
        
    // }

    // public function check() {
    //     if(isset(session))
    // }


    public static function make(array $userData) {
        // create user object 
        $user = new User($userData);

        self::$userInstance = $user;

        // store in session 
        $_SESSION['user'] = serialize($user);
        echo $user->name;

        return $user;
    }   
}