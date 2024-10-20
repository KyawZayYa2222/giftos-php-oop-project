<?php

namespace App\Controller;

use App\Database\Connection;
use App\Helper\Paginator;

class ProductController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // get paginate
    public function get(int $page = 1) {
        $limit = 8;
        $sql = "SELECT products.*, categories.name AS category_name FROM products
                LEFT JOIN categories ON products.category_id = categories.id";

        try {
            $data = Paginator::paginate($this->connect, $sql, $limit, $page);
            return $data;
        } catch(Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Store 
    public function store($request, $file) {
        echo 'success';
        // $categoryId = $request['category_id'];
        // $name = $request['name'];
        // $price = $request['price'];
        // $qty = $request['qty'];
        


        // $sql = "INSERT INTO products (name) VALUES ('$request['name']')";

        // try {
        //     $this->connect->query($sql);
        //     header("Location: category.php");
        //     // echo "<div class='success-alert'>Category created successful.</div>";
        //     exit();
        // } catch (Exception $err) {
        //     echo "<div class='err-exception-con'>$err</div>";
        // }
    }

    
    private function GetQuery($sql) {
        $result = $this->connect->query($sql);

        return $result;
    }

}