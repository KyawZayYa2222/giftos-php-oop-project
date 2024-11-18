<?php
namespace App\Controller;

use App\Database\Connection;
use Exception;
use App\Helper\Paginator;
use App\Helper\Auth;
use App\Helper\DateTime;
use App\Helper\ThrowError;

class OrderController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    
    // Get 
    public function get(int $page=1) {
        $sql = "SELECT orders.*, users.name AS user_name FROM orders
                LEFT JOIN users ON orders.user_id = users.id";
        $limit = 15;

        $data = Paginator::paginate($this->connect, $sql, $limit, $page);
        return $data;
    }

    // Search 
    public function search($search='') {
        $sql = "SELECT orders.*, users.name AS user_name FROM orders
                LEFT JOIN users ON orders.user_id = users.id
                WHERE orders.invoice_id LIKE '%$search%'
                OR users.name LIKE '%$search%'
                OR orders.shipping_address LIKE '%$search%'
                OR orders.payment_type LIKE '%$search%'
                OR orders.status LIKE '%$search%'";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }
    

    // Store 
    public function store($request) {
        $carts = $_SESSION['carts'];

        // check product qty enought for the order 
        foreach ($carts as $cart) {
            $sql = "SELECT * FROM products WHERE id='$cart[id]' AND qty >= '$cart[cart_qty]'";
            $result = $this->connect->query($sql);
            if($result->num_rows == 0) {
                return [
                    'success' => false,
                    'message' => "Not enough product in stock for your order."
                ];
            }
        }

        $stmt = $this->connect->prepare("INSERT INTO orders (invoice_id, items, user_id, total_cost, shipping_address, payment_type, created_at) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $invoiceId, $items, $userId, $totalCost, $shippingAddress, $payment, $created_at);
        
        if(isset($carts) && !empty($carts)) {
            try {
                $invoiceId = "INV" . DateTime::getDate("Y-m-dH:i:s") . rand(100, 999);
                $userId = Auth::user()->id;
                $shippingAddress = $request['shipping_address'];
                $payment = $request['payment_type'];
                $items = [];
                $totalCost = 0;
                $created_at = DateTime::getDate("Y-m-d H:i:s");

                foreach ($carts as $cart) {
                    $productId = $cart['id'];
                    $itemQty = $cart['cart_qty'];
                    $price = $cart['price'];

                    $items[] = [
                        'product_id' => $productId,
                        'qty' => $itemQty,
                        'price' => $price
                    ];
                    $totalCost += $price * $itemQty;
                    
                    // Update product stock 
                    $productUpdateStmt = $this->connect->prepare("UPDATE products SET qty=qty-'$itemQty' WHERE id='$productId'");
                    $productUpdateStmt->execute();
                }

                $items = json_encode($items);
                $result = $stmt->execute();

                if($result) {
                    unset($_SESSION['carts']);
                    header("Location: cart.php");
                    exit();
                }
            } catch (Exception $err) {
                $this->connect->rollback();
                ThrowError::error($err);
            }
        }
    }


    // find 
    public function find($id) {
        $sql = "SELECT orders.*, users.name AS user_name, users.email AS user_email,
                users.phone AS user_phone FROM orders
                LEFT JOIN users ON orders.user_id = users.id
                WHERE orders.id='$id'";

        $data = $this->connect->query($sql);

        return $data;
    }


    // Update 
    // public function update($request) {
    //     $id = $request['id'];
    //     $name = $request['name'];

    //     $sql = "UPDATE categories SET name='$name' WHERE id='$id'";

    //     try {
    //         $this->connect->query($sql);
    //         header("Location: category.php");
    //         // echo "<div class='success-alert'>Category created successful.</div>";
    //         exit();
    //     } catch (Exception $err) {
    //         ThrowError::error($err);
    //     }
    // }


    // Delete 
    // public function delete($request) {
    //     $id = $request['id'];

    //     $sql = "DELETE FROM categories WHERE id='$id'";
        
    //     try {
    //         $this->connect->query($sql);
    //         header("Location: " . $_SERVER['HTTP_REFERER']);
    //         exit();
    //     } catch (Exception $err) {
    //         ThrowError::error($err);
    //     }
    // }
}