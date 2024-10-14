<?php
include './includes/header.php';

session_start();
$_SESSION['admin_current_page'] = 'product';
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

</div>
</div>
</div>


<?php
include './includes/footer.php';
?>