<?php
error_reporting(1);

include_once './vendor/autoload.php';
include 'includes/header.php';

use App\Controller\Product;

// store current page session 
session_start();
$_SESSION['currentpage'] = "shop";

$product = new Product();
$data = $product->paginate();

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
      <!-- <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div> -->
      <div class="row">

      <?php
      // print_r($data['rows']);
foreach ($data['rows'] as $row) {
  // print_r($row['name']);
      ?>

        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="">
              <div class="img-box">
                <img src="images/p1.png" alt="">
              </div>
              <div class="detail-box">
                <h6>
                  <?php echo $row['name'] ?>
                </h6>
                <h6>
                  Price
                  <span>
                  <?php echo "$" . $row['price'] ?>
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
      <div class="btn-box">
        <a href="">
          View All Products
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->


<?php

include 'includes/footer.php';

?>