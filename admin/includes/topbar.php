<?php
use App\Helper\Auth;
use App\Helper\MediaAsset;

$authUser = Auth::user();

// Logout 
if (isset($_POST['logout'])) {
    Auth::logout();
    header("Location: /login.php");
    exit();
  }
?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow ml-auto" style="list-style: none !important;">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $authUser->name ?></span>
            <img class="img-profile rounded-circle"
                src="<?php echo ($authUser->avatar != null ? MediaAsset::assets($authUser->avatar) : MediaAsset::assets('images/blank_profile.jpg')) ?>">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item py-2" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <!-- <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Settings
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                Activity Log
            </a> -->
            <div class="dropdown-divider"></div>
            <div class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <form action="" method="POST">
                <button class="btn btn-sm" type="submit" name="logout">
                <i class="fa fa-sign-out mr-2"></i>Logout</button>
            </form>
            </div>
            <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a> -->
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->