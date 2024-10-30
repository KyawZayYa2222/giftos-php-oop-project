<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;
use App\Helper\Paginator;
use App\Helper\DateTime;


class ContactController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // Store 
    public function store($request) {
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $message = $request['message'];
        $created_at = DateTime::getDate("Y-m-d H:i:s");

        $sql = "INSERT INTO contacts (name, email, phone, message, created_at) 
                VALUES ('$name', '$email', '$phone', '$message', '$created_at')";

        try {
            $this->connect->query($sql);

            return [
                'status'=> true,
                'message' => "Your message successfully send."
            ];
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }
}