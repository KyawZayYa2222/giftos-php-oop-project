<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/header.php';

use App\Controller\ContactController;
use App\Helper\MediaAsset;
use App\Helper\Auth;


$_SESSION['admin_current_page'] = 'contact';

$contactController = new ContactController();   

if (isset($_GET['page'])) {
    $contacts = $contactController->get($_GET['page']);
} else {
    $contacts = $contactController->get();
}

// search 
if(isset($_GET['search'])) {
    $contacts = $contactController->search($_GET['search']);
}

// delete 
// if(isset($_POST['delete'])) {
//     $contactController->delete($_POST);
// }
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
    <h1 class="h3 text-gray-800">Contact</h1>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="320px">Message</th>
                        <th>Status</th>
                        <th width="200px">Date</th>
                        <th width="60px">Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php
    foreach ($contacts['data'] as $key => $contact) {
        $no = $key + 1;
        $id = $contact['id'];
        $name = htmlspecialchars($contact['name'] ?? '');
        $email = htmlspecialchars($contact['email'] ?? '');
        $phone = htmlspecialchars($contact['phone'] ?? '09 __');
        $message = htmlspecialchars($contact['message'] ?? '__');

        echo "<tr>
                <td>$no</td>
                <td> $name </td>
                <td>$email</td>
                <td>$phone</td>
                <td>
                <p class='text-truncate' style='width: 300px !important;'>
                lorem isjhd hehehhehehe hh hshil uou orange apple this is a sentences and I forgot
                </p>
                </td>
                <td>{$contact['status']}</td>
                <td>{$contact['created_at']}</td>
                <td>
                <div class='d-flex'>
                    <a href='/admin/contact_detail.php?id=$id' class='btn btn-sm btn-primary mr-2'>
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
        if(isset($contact['link'])) {
            echo $contact['link'];
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