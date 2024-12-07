<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;
use App\Helper\Paginator;
use App\Helper\DateTime;
use App\Helper\ThrowError;


class ContactController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    // Get 
    public function get(int $page=1) {
        $sql = "SELECT * FROM contacts";
        $limit = 15;

        $data = Paginator::paginate($this->connect, $sql, $limit, $page);
        return $data;
    }

    // Search 
    public function search($search='') {
        $sql = "SELECT * FROM contacts WHERE name LIKE '%$search%'
                OR name LIKE '%$search%'
                OR email LIKE '%$search%'
                OR phone LIKE '%$search%'
                OR status LIKE '%$search%'";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }

    // Find 
    public function find($id) {
        try {
            $sql = "SELECT * FROM contacts WHERE id = '$id'";
            $data = $this->connect->query($sql);
            return $data;
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }

    // Store 
    public function store($request) {
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $message = $request['message'];
        $created_at = DateTime::getDate("Y-m-d H:i:s");

        // $sql = "INSERT INTO contacts (name, email, phone, message, created_at) 
        //         VALUES ('$name', '$email', '$phone', '$message', '$created_at')";

        $stmt = $this->connect->prepare("INSERT INTO contacts (name, email, phone, message, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $message, $created_at);

        try {
            // $this->connect->query($sql);
            $stmt->execute();
            $stmt->close();

            return [
                'success'=> true,
                'message' => "Your message successfully send."
            ];
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Mark as read 
    public function markAsRead($id) {
        $sql = "UPDATE contacts SET status = 'read' WHERE id = '$id'";

        try {
            $this->connect->query($sql);
            return [
               'success'=> true,
               'message' => "Message marked as read successfully."
            ];
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }
}