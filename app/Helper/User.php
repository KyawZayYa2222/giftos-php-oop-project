<?php
namespace App\Helper;

// User object 
class User {
    public $attributes = [];
    
    function __construct(array $userData) {
        $this->id = $userData['id']?? '';
        $this->name = $userData['name'] ?? '';
        $this->email = $userData['email'] ?? '';
        $this->userType = $userData['user_type'] ?? '';
        $this->avatar = $userData['avatar'] ?? '';
        $this->shipping_address = $userData['shipping_address']?? '';
        $this->created_at = $userData['created_at'] ?? '';
    }

    // setter 
    public function __set($key, $value) {
        $this->attributes[$key] = $value;
        $_SESSION['user'] = serialize($this);
    }

    // getter 
    public function __get($key) {
        if (array_key_exists($key, $this->attributes)) {
			return $this->attributes[$key] ?? '';
		}
    }

    // update 
    public function update(array $userData) {
        foreach ($userData as $key => $value) {
            $this->__set($key, $value);
        }
    }
        
}