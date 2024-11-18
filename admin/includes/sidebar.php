<?php

include_once '../vendor/autoload.php';

use Dotenv\Dotenv;

$currentPage = $_SESSION['admin_current_page'];

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();


?>


<!-- Sidebar -->
<ul class="navbar-nav custom-primary-color sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text ;mx-3 text-white"> <?php echo $_ENV['APP_NAME'] ?> </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider mb-1">

<li class="nav-item <?php if($currentPage === 'index') echo 'active'; ?>">
    <a class="nav-link" href="/admin/index.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span></a>
</li>

<hr class="sidebar-divider mb-1">

<li class="nav-item <?php if($currentPage === 'category' || $currentPage === 'category_create' || $currentPage === 'category_edit') echo 'active'; ?>">
    <a class="nav-link custom-nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
        aria-expanded="true" aria-controls="collapseCategory">
        <i class="fa fa-th-large"></i>
        <span>Category</span>
        <i class="fa fa-chevron-right ms-auto"></i>
    </a>
    <div id="collapseCategory" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($currentPage === 'category') echo 'active'; ?>" href="/admin/category.php">List</a>
            <a class="collapse-item <?php if($currentPage === 'category_create') echo 'active'; ?>" href="/admin/category_create.php">Create</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider mb-1">

<li class="nav-item <?php if($currentPage === 'product' || $currentPage === 'product_create' || $currentPage === 'product_edit') echo 'active'; ?>">
    <a class="nav-link custom-nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
        aria-expanded="true" aria-controls="collapseProduct">
        <i class="fa fa-cubes"></i>
        <span>Product</span>
        <i class="fa fa-chevron-right ms-auto"></i>
    </a>
    <div id="collapseProduct" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($currentPage === 'product') echo 'active'; ?>" href="/admin/product.php">List</a>
            <a class="collapse-item <?php if($currentPage === 'product_create') echo 'active'; ?>" href="/admin/product_create.php">Create</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider mb-1">

<li class="nav-item <?php if($currentPage === 'order' || $currentPage === 'order_detail') echo 'active'; ?>">
    <a class="nav-link" href="/admin/order.php">
        <i class="fa fa-dollar"></i>
        <span>Order</span></a>
</li>

<hr class="sidebar-divider mb-1">

<li class="nav-item <?php if($currentPage === 'customer') echo 'active'; ?>">
    <a class="nav-link" href="/admin/customer.php">
        <i class="fa fa-users"></i>
        <span>Customer</span></a>
</li>

<hr class="sidebar-divider mb-1">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline mt-5">
    <button class="rounded-circle border-0" id="sidebarToggle">
        <i class="fa fa-bars text-light"></i>
    </button>
</div>


</ul>
<!-- End of Sidebar -->