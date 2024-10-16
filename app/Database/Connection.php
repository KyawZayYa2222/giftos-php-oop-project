<?php

namespace App\Database;

include_once './vendor/autoload.php';

use Dotenv\Dotenv;

class Connection {
    private $servername;
    private $username;
    private $password;
    private $db;
    // private $connect;

    function __construct() {
        $this->connect();
    }

    public function connect() {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->servername = $_ENV['DB_HOSTNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->db = $_ENV['DB_NAME'];

        // Create connection 
        $connect = new \mysqli($this->servername, $this->username, $this->password, $this->db);

        // Check connection 
        if($connect->connect_error) {
            die("Database connection Failed: ". $connect->connect_error);
        }

        // echo "Database is connected successfullly";
        return $connect;
    }
}

