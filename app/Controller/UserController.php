<?php
namespace App\Controller;

use App\Database\Connection;
use App\Helper\DateTime;
use App\Helper\Auth;


class UserController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    // register 
    public function register($request) {
        $name = $request['name'];
        $email = $request['email'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        $userType = 'user';

        $dataTime = new DateTime();
        $created_at = $dataTime->getDate("Y-m-d H:i:s");

        $sql = "INSERT INTO users (name, email, password, user_type, created_at) 
                VALUES ('$name', '$email', '$password', '$userType', '$created_at')";

        try {
            $data = $this->connect->query($sql);
            Auth::make([
                'name' => $name,
                'email' => $email,
                'user_type' => $userType,
                'created_at' => $created_at
            ]);
            header("Location: index.php");
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // check email exist 
    public function checkEmailExist($email) {
        $sql = "SELECT * FROM users WHERE email='$email'";

        $data = $this->connect->query($sql);
        $check = $data->num_rows > 0 ? true : false; 
        return $check;
    }

}