<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/header.php';

use App\Controller\OrderController;
use App\Helper\MediaAsset;
use App\Helper\Auth;
use App\Controller\UserController;


$_SESSION['admin_current_page'] = 'order';

$orderController = new OrderController();   

if (isset($_GET['page'])) {
    $orders = $orderController->get($_GET['page']);
} else {
    $orders = $orderController->get();
}

// search 
if(isset($_GET['search'])) {
    $orders = $orderController->search($_GET['search']);
}

// delete 
if(isset($_POST['delete'])) {
    $orderController->delete($_POST);
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
<div class="d-flex mb-2 justify-content-start">
    <h1 class="h3 text-gray-800">Order</h1>
    <!-- <a href="/admin/product_create.php" class="btn btn-primary">Create</a> -->
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET"
            class="d-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-1 small" 
                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                value="<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Invoice Id</th>
                        <th>Customer</th>
                        <!-- <th>Product</th> -->
                        <!-- <th>Qty</th> -->
                        <!-- <th>Price</th> -->
                        <th>Total Cost</th>
                        <th>Shipping Address</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th width="100px">Actions</th>
                        <!-- <th>Start d/ate</th>
                        <th>Salary</th> -->
                    </tr>
                </thead>
                <tbody>
<?php
    foreach ($orders['data'] as $key => $order) {
        $no = $key + 1;
        $id = $order['id'];
        $userController = new UserController();
        $user = $userController->find($order['user_id'])->fetch_assoc();

        echo "<tr >
                <td>$no</td>
                <td>{$order['invoice_id']}</td>
                <td>{$user['name']}</td>
                <td><span class='text-primary'>$</span> {$order['total_cost']}</td>
                <td>{$order['shipping_address']}</td>
                <td>{$order['payment_type']}</td>
                <td>{$order['status']}</td>
                <td>
                <div class='d-flex justify-content-center'>
                    <a href='/admin/order_detail.php?id=$id' class='btn btn-sm btn-primary mr-2'>
                     <i class='fa fa-eye'></i>
                    </a>
                </div>
                </td>
            </tr>";
    }

?>
                    
                </tbody>
            </table>

            <?php 
        if(isset($orders['link'])) {
            echo $orders['link'];
        }
        ?>

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