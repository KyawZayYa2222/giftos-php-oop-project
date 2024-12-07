<?php
error_reporting(1);

use App\Helper\Auth;

$currentPage = $_SESSION['currentpage'];

// echo $currentPage;
$menuPages = ['index' => 'Home', 'shop' => 'Shop', 'why' => 'Why Us', 'contact' => 'Contact Us'];

?>

<!-- header section strats -->
<header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.php">
          <span>
          <?php echo $_ENV['APP_NAME'] ?>
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
  <?php
    foreach ($menuPages as $link => $page) {
  ?>
            <li class="nav-item <?php if($link === $currentPage) {echo "active";} ?>">
              <a class="nav-link"  href="<?php echo $link . '.php' ?>">
                  <?php echo $page; ?>
              </a>
            </li>

  <?php } ?>

          </ul>
          <div class="user_option">

          <?php if(Auth::check()) {?>
            <a href="profile.php?active-section=edit">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>
                Profile
              </span>
            </a>

            <a href="cart.php">
              <div class="cart-icon">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              <span id="cart-item-count">
              <?php
                $carts = isset($_SESSION['carts']) ? $_SESSION['carts'] : [];
                $count = count($carts);
                echo $count;
              ?>
              </span>
              </div>
            </a>
            <?php } else { ?>
              <a href="login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>
                  Login
                </span>
              </a>
              <a href="login.php">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </a>
            <?php } ?>

          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->