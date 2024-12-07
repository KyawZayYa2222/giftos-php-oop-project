<?php

namespace App\Controller;

use App\Database\Connection;
use App\Helper\Paginator;
use App\Helper\FileUpload;
use Exception;

class ProductController {
    private $connect;
    private $baseSql = "SELECT products.*, categories.name AS category_name FROM products
                        LEFT JOIN categories ON products.category_id = categories.id ";

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // get paginate
    public function get(int $page = 1, $order = 'ASC') {
        $limit = 15;
        $sql = $this->baseSql . "ORDER BY products.id $order";

        try {
            $data = Paginator::paginate($this->connect, $sql, $limit, $page);
            return $data;
        } catch(Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // search 
    public function search($search='') {
        $sql = $this->baseSql . "WHERE products.name LIKE '%$search%'
                OR products.price LIKE '%$search%' OR categories.name LIKE '%$search%'";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    public function latest() {
        $sql = $this->baseSql . "ORDER BY products.id DESC LIMIT 8";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Find 
    public function find($id) {
        $sql = $this->baseSql . "WHERE products.id = '$id'";

        $data = $this->connect->query($sql);

        return $data;
    }


    // Store 
    public function store($request, $files) {
        // store image 
        $image = $this->UploadImage($files);

        $categoryId = $request['category_id'];
        $name = $request['name'];
        $price = $request['price'];
        $qty = $request['qty'];


        $sql = "INSERT INTO products (name, price, qty, category_id, image) 
                VALUES ('$name', '$price', '$qty', '$categoryId', '$image')";

        try {
            $this->connect->query($sql);
            header("Location: product.php");
            // echo "<div class='success-alert'>Category created successful.</div>";
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Update 
    public function update($request, $files) {
        // store image 
        $image = $this->UploadImage($files, $request['old_image']);
        $productId = $request['id'];
        $categoryId = $request['category_id'];
        $name = $request['name'];
        $price = $request['price'];
        $qty = $request['qty'];

        $sql = "UPDATE products SET category_id='$categoryId', name='$name', price='$price', qty='$qty', image='$image'
                WHERE id='$productId'";

        try {
            $this->connect->query($sql);
            header("Location: product.php");
            // echo "<div class='success-alert'>Category created successful.</div>";
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Delete 
    public function delete($request) {
        $id = $request['id'];

        $sql = "DELETE FROM products WHERE id='$id'";

        try {
            $this->connect->query($sql);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }

    
    // private function GetQuery($sql) {
    //     $result = $this->connect->query($sql);

    //     return $result;
    // }

    
    private function UploadImage($files, $oldFile = null) {
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $check = getimagesize($files["image"]["tmp_name"]);
            if($check !== false) {
                $dir = 'images/product_images/';
                $fileUpload = new FileUpload($dir, $files['image'], $oldFile);
                $image = $fileUpload->upload();
            }
        }

        return $image;
    }

}