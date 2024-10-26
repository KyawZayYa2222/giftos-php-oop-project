<?php
namespace App\Helper;

// User object 
class User {
    public $name, $email, $userType, $avatar, $created_at;
    
    function __construct(array $userData) {
        $this->name = $userData['name'] ?? '';
        $this->email = $userData['email'] ?? '';
        $this->userType = $userData['user_type'] ?? '';
        $this->avatar = $userData['avatar'] ?? '';
        $this->created_at = $userData['created_at'] ?? '';
    }
}