<?php
error_reporting(1);

include_once './vendor/autoload.php';
include 'includes/header.php';

use App\Controller\ProductController;

// store current page session 
session_start();
$_SESSION['currentpage'] = "shop";

$productController = new ProductController();

if (isset($_GET['page'])) {
  $products = $productController->get($_GET['page']);
} else {
  $products = $productController->get();
}
?>

<div class="hero_area">

    <?php
    include 'includes/navbar.php';
    ?>

  </div>
  <!-- end hero area -->

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="row">

      <?php
foreach ($products['data'] as $product) {
      ?>

        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="">
              <div class="img-box">
                <img src="images/p1.png" alt="">
              </div>
              <div class="detail-box">
                <h6>
                  <?php echo $product['name'] ?>
                </h6>
                <h6>
                  Price
                  <span>
                  <?php echo "$" . $product['price'] ?>
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  New
                </span>
              </div>
            </a>
          </div>
        </div>

        <?php } ?>

      </div>
      <!-- <div class="btn-box">
        <a href="">
          View All Products
        </a>
      </div> -->
    </div>

    <div class="container-fluid mt-3">
    <?php echo $products['link'] ?>
    </div>
  </section>

  <!-- end shop section -->


<?php

include 'includes/footer.php';

?>