<?php

namespace App\Database;

use Dotenv\Dotenv;

include_once './vendor/autoload.php';

class Connection {
    private $servername;
    private $username;
    private $password;

    function __construct() {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->servername = $_ENV['DB_HOSTNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        // var_dump(getenv('DB_USERNAME'));
        // echo $_ENV['DB_USERNAME'];

        // Create connection 
        $connect = new \mysqli($this->servername, $this->username, $this->password);

        // Check connection 
        if($connect->connect_error) {
            die("connection Failed: ". $connect->connect_error);
        }

        echo "connected successfullly";
    }
}

