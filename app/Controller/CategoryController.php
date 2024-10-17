<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;
use App\Helper\Paginator;


class CategoryController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    
    // Get 
    public function get(int $page=1) {
        $tableName = "categories";
        $limit = 15;

        $data = Paginator::paginate($this->connect, $tableName, $limit, $page);
        return $data;
    }

    // Store 
    public function store($request) {
        $name = $request['name'];

        $sql = "INSERT INTO categories (name) VALUES ('$name')";

        try {
            $this->connect->query($sql);
            header("Location: category.php");
            // echo "<div class='success-alert'>Category created successful.</div>";
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }
}