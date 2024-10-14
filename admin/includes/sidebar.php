<?php

include_once '../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();
$currentPage = $_SESSION['admin_current_page'];

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

// $pages = ['index' => 'Dashboard', 'product' => 'Product'];
// $menuIcons = ['index' => 'dashboard', 'product' => 'th'];

?>


<!-- Sidebar -->
<ul class="navbar-nav custom-primary-color sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text ;mx-3"> <?php echo $_ENV['APP_NAME'] ?> </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider mb-2">

<li class="custom-nav">
    <a class="custom-nav-link <?php if($currentPage === 'index') echo 'active'; ?>" href="/admin/index.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span></a>
</li>

<li class="nav-item">
    <a class="nav-link custom-nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fa fa-th"></i>
        <span>Product</span>
        <i class="fa fa-chevron-right ms-auto"></i>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <a class="collapse-item" href="/admin/product.php">Category</a>
            <a class="collapse-item" href="/admin/product.php">Products</a>
            <!-- <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a> -->
        </div>
    </div>
</li>


<li class="custom-nav">
    <a class="custom-nav-link <?php if($currentPage === 'index') echo ''; ?>" href="/admin/index.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span></a>
</li>

</ul>
<!-- End of Sidebar -->