<?php
error_reporting(1);

// include_once './vendor/autoload.php';
include 'includes/header.php';

use App\Controller\ProductController;
use App\Helper\MediaAsset;

// store current page session 
// session_start();
$_SESSION['currentpage'] = "shop";

$productController = new ProductController();

// pagination 
if (isset($_GET['page'])) {
  $products = $productController->get($_GET['page']);
} else {
  $products = $productController->get();
}

// search 
if(isset($_GET['search'])) {
  $products = $productController->search($_GET['search']);
}
?>

<div class="hero_area">

    <?php
    include 'includes/navbar.php';
    ?>

  </div>
  <!-- end hero area -->

  <div class="d-flex justify-content-center mt-4">
    <form action="" class="search-form d-flex">
      <input type="text" name="search" class="search-input"
      value="<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>">

      <button type="submit" class="search-btn">
      <i class="fa fa-search" aria-hidden="true"></i>
      </button>
    </form>
  </div>

  <!-- shop section -->

  <section class="shop_section layout_padding pt-5">
    <div class="container">
      <div class="row">

      <?php
foreach ($products['data'] as $product) {
      ?>

        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <!-- <a href=""> -->

<?php
$image = $product['image'] != null ? MediaAsset::assets($product['image']) : MediaAsset::assets('images/gifts.png');
?>
            <a href="">
              <div class="img-box">
                <img src="<?php echo $image ?>" alt="">
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
              </a>
              <div class="card-con">
                <?php if($product['qty'] === 0) { 
                  echo `<span class="badge text-white bg-danger">Stock out</span>`;
                } else {
                  echo "<button onclick=\"actionToCart({$product['id']}, 'add')\">
                        <i class=\"fa fa-shopping-bag\" aria-hidden=\"true\"></i>
                        </button>";
                }
                ?>
              </div>
          </div>
        </div>

        <?php } ?>

      </div>
    </div>

    <div class="container-fluid mt-3">
    <?php echo $products['link'] ?>
    </div>
  </section>

  <!-- end shop section -->


<?php

include 'includes/footer.php';

?>