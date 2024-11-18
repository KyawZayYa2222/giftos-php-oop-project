<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/header.php';

use App\Controller\UserController;
use App\Helper\MediaAsset;
use App\Helper\Auth;


$_SESSION['admin_current_page'] = 'customer';

$userController = new UserController();   

if (isset($_GET['page'])) {
    $users = $userController->get($_GET['page']);
} else {
    $users = $userController->get();
}

// search 
if(isset($_GET['search'])) {
    $users = $userController->search($_GET['search']);
}

// delete 
if(isset($_POST['delete'])) {
    $userController->delete($_POST);
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
    <h1 class="h3 text-gray-800">Customer</h1>
    <!-- <a href="/admin/product_create.php" class="btn btn-primary">Create</a> -->
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Shipping_address</th>
                        <th width="160px">Actions</th>
                        <!-- <th>Start d/ate</th>
                        <th>Salary</th> -->
                    </tr>
                </thead>
                <tbody>
<?php
    foreach ($users['data'] as $key => $user) {
        $no = $key + 1;
        $id = $user['id'];
        $name = htmlspecialchars($user['name'] ?? '');
        $email = htmlspecialchars($user['email'] ?? '');
        $phone = htmlspecialchars($user['phone'] ?? '09 __');
        $shippingAddress = htmlspecialchars($user['shipping_address'] ?? '__');
        $image = $user['avatar'] != null ? MediaAsset::assets($user['avatar']) : MediaAsset::assets('images/blank_profile.jpg');

        echo "<tr>
                <td>$no</td>
                <td>
                <span class='table-icon-img mr-2'>
                    <img src='$image' alt='image'>
                </span>
                $name
                </td>
                <td>$email</td>
                <td>$phone</td>
                <td>$shippingAddress</td>
                <td>
                <div class='d-flex'>
                    <form method='POST'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>
                    </form>
                </div>
                </td>
            </tr>";
    }

?>
                    
                </tbody>
            </table>

            <?php 
        if(isset($users['link'])) {
            echo $users['link'];
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