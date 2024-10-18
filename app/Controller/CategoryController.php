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

    // Search 
    public function search($search='') {
        $sql = "SELECT * FROM categories WHERE name LIKE '%$search%'";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
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


    // Store 
    public function update($request) {
        $id = $request['id'];
        $name = $request['name'];

        $sql = "UPDATE categories SET name='$name' WHERE id='$id'";

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