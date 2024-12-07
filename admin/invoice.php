<?php
include './includes/header.php';

use App\Controller\OrderController;
use App\Controller\ProductController;
// use Rakit\Validation\Validator;
// use App\Helper\Auth;


// $_SESSION['admin_current_page'] = 'order_deatil';

$orderController = new OrderController();

// prevent invalid product 
$query = $orderController->find($_GET['id']);
if($query->num_rows === 0) {
    header("Location: order.php");
} else {
    $order = $query->fetch_assoc();
}
?>

<div class="mb-4 p-5">
    <div class="text-center mb-3">
        <h1>GIFTOS</h1>
        <h4>Order Reciepts</h4>
    </div>
        <div class="d-flex justify-content-between mb-3">
            <div>
                Invoice ID: <strong><?php echo $order['invoice_id'];?></strong><br>
                Payment Type: <strong><?php echo $order['payment_type'];?></strong><br>
                Date: <strong><?php echo $order['created_at'];?></strong>
            </div>
            <div>
                Customer Name: <strong><?php echo $order['user_name'];?></strong><br>
                Email: <strong><?php echo $order['user_email'];?></strong><br>
                Phone: <strong><?php echo $order['user_phone'] != '' ? $order['user_phone'] : '__' ;?></strong><br>
                Shipping Address: <strong><?php echo $order['shipping_address'] != '' ? $order['shipping_address'] : '__' ;?></strong><br>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $items = json_decode($order['items'], true);
    foreach ($items as $key => $item) {
        $no = $key + 1;
        $productController = new ProductController();
        $product = $productController->find($item['product_id'])->fetch_assoc();
        $totalCost = $item['price'] * $item['qty'];

        echo "<tr >
                <td>$no</td>
                <td>{$product['name']}</td>
                <td><span class='text-primary'>$</span> {$item['price']}</td>
                <td>{$item['qty']}</td>
                <td><span class='text-primary'>$</span> $totalCost</td>
            </tr>";
    }
    echo "<tr>
            <td colspan='4' class='text-right'>All Total Cost</td>
            <td><span class='text-primary'>$</span> $order[total_cost]</td>
        </tr>";
?>
                    
                </tbody>
            </table>
        </div>
    </div>