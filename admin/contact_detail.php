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

// prevent invalid product 
$query = $contactController->find($_GET['id']);
if($query->num_rows === 0) {
    header("Location: contact.php");
} else {
    $contact = $query->fetch_assoc();
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
    <h1 class="h3 text-gray-800">Contact</h1>
    <!-- <a href="/admin/product_create.php" class="btn btn-primary">Create</a> -->
</div>

<!-- DataTales Example -->
<?php
    $id = $contact['id'];
    $name = htmlspecialchars($contact['name'] ?? '');
    $email = htmlspecialchars($contact['email'] ?? '');
    $phone = htmlspecialchars($contact['phone'] == '' ? '09 __' : $contact['phone']);
    $message = htmlspecialchars($contact['message'] ?? '__');
?>
    
<div class="card shadow mb-4 p-0 container">
    <div class="card-header" id="contact-detail-<?php echo $id ?>">
        <?php if($contact['status'] !== 'unread') { ?>
            <button disabled class="btn float-right">Already read</button>
        <?php } else { ?>
            <button onclick="markAsRead(<?php echo $id ?>)" class="btn btn-primary float-right">
                Mark as read
            </button>
        <?php } ?>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col col-4 text-right">Name : </div>
        <div class="col col-8 mb-3"><?php echo $name ?></div>
        <div class="col col-4 text-right">Email : </div>
        <div class="col col-8 mb-3"><?php echo $email ?></div>
        <div class="col col-4 text-right">Phone : </div>
        <div class="col col-8 mb-3"><?php echo $phone ?></div>
        <div class="col col-4 text-right">Message : </div>
        <div class="col col-8 mb-3 pr-5"><?php echo $message ?></div>
        <div class="col col-4 text-right">Received Date : </div>
        <div class="col col-8 mb-3"><?php echo $contact['created_at'] ?></div>
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