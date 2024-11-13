<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;
use App\Helper\Paginator;
use App\Helper\Auth;
use App\Helper\DateTime;

class OrderController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // public function all() {
    //     $sql = "SELECT * FROM categories";
        
    //     try {
    //         $data = $this->connect->query($sql)->fetch_all(MYSQLI_ASSOC);
    //         return $data;
    //     } catch(Exception $err) {
    //         echo "<div class='err-exception-con'>$err</div>";
    //     }
    // }
    
    // Get 
    public function get(int $page=1) {
        $sql = "SELECT * FROM categories";
        $limit = 15;

        $data = Paginator::paginate($this->connect, $sql, $limit, $page);
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
        $invoiceId = "INV" . DateTime::getDate("Y-m-dH:i:s") . rand(100, 999);
        $payment = $request['payment_type'];
        $carts = $_SESSION['carts'];
        $userId = Auth::user()->id;
        $created_at = DateTime::getDate("Y-m-d H:i:s");

        $values = [];
        $sql = "INSERT INTO orders (invoice_id, product_id, user_id, qty, price, total_cost, shipping_address, payment_type, created_at) VALUES ";
        if(isset($carts) && !empty($carts)) {
            foreach ($carts as $cart) {
                $totalCost = $cart['price'] * $cart['cart_qty'];
                $values[] = "('$invoiceId', '$cart[id]', '$userId', '$cart[cart_qty]', '$cart[price]', '$totalCost', '$cart[shipping_address]', '$payment', '$created_at)";
            }
        }

        // to be continued ....


        // if(!empty($values)) {
        //     $sql.= implode(', ', $values);
        //     try {
        //         $result = $this->connect->query($sql);
        //         if($result) {
        //             // reduce the qty of product in the database 
        //             foreach ($carts as $cart) {
        //                 $sql = "UPDATE products SET qty=qty-'$cart[cart_qty]' WHERE id='$cart[id]'";
        //                 $this->connect->query($sql);
        //             }
    
        //         }
        //         unset($_SESSION['carts']);
        //         header("Location: orders.php");
        //         exit();
        //     } catch (Exception $err) {
        //         echo "<div class='err-exception-con'>$err</div>";
        //     }
        // }
        
    }


    // find 
    public function find($id) {
        $sql = "SELECT * FROM categories WHERE id='$id'";
        $data = $this->connect->query($sql);

        return $data;
    }


    // Update 
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


    // Delete 
    public function delete($request) {
        $id = $request['id'];

        $sql = "DELETE FROM categories WHERE id='$id'";
        
        try {
            $this->connect->query($sql);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }
}