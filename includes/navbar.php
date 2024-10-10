<?php
error_reporting(1);

session_start();

$currentPage = $_SESSION['currentpage'];

// echo $currentPage;
$menuPages = ['index' => 'Home', 'shop' => 'Shop', 'why' => 'Why', 'contact' => 'Contact'];

?>

<!-- header section strats -->
<header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.php">
          <span>
            Giftos
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
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $link . '.php' ?>">
              <!-- <span class="sr-only">(current)</span> -->
                  <?php
                  echo $page;
                  // active menu link 
                  if($link == $currentPage) {
                    // echo "helo";
                    echo '<span class="sr-only">(current)</span>';
                  }
                  ?>  
              </a>
            </li>

  <?php } ?>



            <!-- <li class="nav-item ">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php">
                Shop
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="why.php">
                Why Us
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="testimonial.php">
                Testimonial
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li> -->
          </ul>
          <div class="user_option">
            <a href="">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>
                Login
              </span>
            </a>
            <a href="">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </a>
            <form class="form-inline ">
              <button class="btn nav_search-btn" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->