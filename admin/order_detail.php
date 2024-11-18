<?php
// include_once './vendor/autoload.php';
include './includes/header.php';

use App\Controller\OrderController;
use App\Controller\ProductController;
use Rakit\Validation\Validator;
use App\Helper\Auth;


$_SESSION['admin_current_page'] = 'order_deatil';

$orderController = new OrderController();

// prevent invalid product 
$query = $orderController->find($_GET['id']);
if($query->num_rows === 0) {
    header("Location: order.php");
} else {
    $order = $query->fetch_assoc();
}
?>



<div id="wrapper">
<?php
include './includes/sidebar.php';
?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<?php
include './includes/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-flex mb-2 justify-content-between">
    <h1 class="h3 text-gray-800">Order</h1>
    <!-- <button type="submit" name="category_edit" class="btn btn-primary">Create</button> -->
</div>

<!-- DataTales Example -->
<div class="">
    <div class="card shadow mb-4 p-3">
        <div class="row row-cols-md-3 row-cols-1 mb-3">
            <div class="col">
                Invoice ID: <strong><?php echo $order['invoice_id'];?></strong><br>
                Payment Type: <strong><?php echo $order['payment_type'];?></strong><br>
                Date: <strong><?php echo $order['created_at'];?></strong>
            </div>
            <div class="col">
                Customer Name: <strong><?php echo $order['user_name'];?></strong><br>
                Email: <strong><?php echo $order['user_email'];?></strong><br>
                Phone: <strong><?php echo $order['user_phone'] != '' ? $order['user_phone'] : '__' ;?></strong><br>
                Shipping Address: <strong><?php echo $order['shipping_address'] != '' ? $order['shipping_address'] : '__' ;?></strong><br>
            </div>
            <div class="col">
                <div class="d-flex justify-content-between">
                    <!-- <br> -->
                    <select class="select-2" id="category_id" name="category_id">
                    <?php
                    $status = ['Pending', 'Processing', 'Delivered', 'Canceled'];
                    foreach ($status as $key => $stat) {
                        $select = $order['status'] == $stat ? 'selected' : '';
                        echo "<option value='{$stat}' $select>{$stat}</option>";
                    }
                    ?>
                    </select>

                    <button class="btn btn-success">
                        <i class="fa fa-print"></i>
                    </button>
                </div>
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
</div>


</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
</div>
</div>
</div>


<?php
include './includes/footer.php';
?>