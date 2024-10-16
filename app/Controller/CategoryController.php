<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;

class CategoryController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    public function store($request) {
        $name = $request['name'];

        $sql = "INSERT INTO categories (name) VALUES ('$name')";

        try {
            $this->connect->query($sql);
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }

        echo "<div class='success-alert'>alert('Category created successful.')</div>";
    }
}