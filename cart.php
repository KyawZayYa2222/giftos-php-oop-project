<?php
error_reporting(1);

include 'includes/header.php';

use Rakit\Validation\Validator;
use App\Helper\MediaAsset;
use App\Controller\CartController;
use App\Helper\Auth;
use App\Controller\OrderController;

$_SESSION['currentpage'] = "cart";
// print_r($_SESSION['carts']);
// session_unset();

// Auth check 
if(!Auth::check()) {
  header("Location: login.php");
  exit();
}

// $cartController = new CartController();

// $cartItems = $cartController->get();

$cartItems = isset($_SESSION['carts'])? $_SESSION['carts'] : [];
$totalCount = count($cartItems);
$totalQty = array_sum(array_map(function($cart) {
  return $cart['cart_qty'];
}, $cartItems));
$totalCost = array_sum(array_map(function($cart) {
  return $cart['price'] * $cart['cart_qty'];
}, $cartItems));

// checkout and order 
if(isset($_POST['checkout'])) {
  $orderController = new OrderController();
  $result = $orderController->store($_POST);
  // print_r($result);
  if(!$result['success']) {
    $message = $result['message'];
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
}
?>


<div class="hero_area">

    <?php
    include 'includes/navbar.php';
    ?>

  </div>
  <!-- end hero area -->

  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="container px-0">
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
            <div class="px-5 py-4" id="cart-item-list">
  <?php 
  if(count($cartItems) == 0) {
    echo '<p class="text-center text-secondary h3 mt-4">Your cart is empty.</p>';
  }
  ?>

              <?php 
              foreach ($cartItems as $item) { 
                $image = $item['image'] != null ? MediaAsset::assets($item['image']) : MediaAsset::assets('images/gifts.png');
              ?>
              <div id="cart-item-<?php echo $item['id'] ?>" class="row border border-secondary rounded-lg p-2 mb-3">
                  <div class="col col-md-2 col-12">
                      <img class="img-thumbnail" src="<?php echo $image ?>" alt="">
                  </div>
                  <div class="col col-md-6">
                      <p><?php echo $item['name'] ?></p>
                      <b class="text-bottom"><?php echo $item['price'] ?>$</b>
                  </div>
                  <div class="col col-md-4">
                    <div class="d-flex h-100 align-items-center justify-content-end">
                      <div class="number-toggler">
                        <button onclick="actionToCart(<?php echo $item['id'] ?>, 'reduce')">-</button>
                        <input type="text" id="cart-item-input-<?php echo $item['id'] ?>" value="<?php echo $item['cart_qty'] ?>" readonly>
                        <button onclick="actionToCart(<?php echo $item['id'] ?>, 'add')">+</button>
                      </div>
                      <button onclick="removeCart(<?php echo $item['id'] ?>, 'remove')" class="cart-item-remove-btn p-1 px-2 rounded m-0 ml-2">
                      <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </div>
              </div>
              <?php }?>
            </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <div class="checkout-header">
            <h4>Payment Checkout</h4>
            <hr class="bg-light">
            <ul>
              <li>
                <div class="d-flex justify-content-between">
                  <span>Total item</span>
                  <span id="cart-total-count"><?php echo $totalCount ?></span>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>Total Quantity</span>
                  <span id="cart-total-qty"><?php echo $totalQty ?></span>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>Total Cost</span>
                  <span id="cart-total-cost"><?php echo $totalCost . '$' ?></span>
                </div>
              </li>
            </ul>
          </div>
          <form action="#" method="POST">
            <div class="payment-type">
              <?php
              $payments = [
                'visa' => '<i class="fa fa-cc-visa"></i>',
                'master' => '<i class="fa fa-cc-mastercard"></i>', 
                'amex' => '<i class="fa fa-cc-amex"></i>', 
                'discover' => '<i class="fa fa-cc-discover"></i>',
              ];
              foreach ($payments as $payment => $icon) {
              ?>
              <div class="payment-type-input">
                <input type="radio" class="radio-input" name="payment_type" <?php echo ($payment === 'visa') ? 'checked' : ''; ?> id="<?php echo $payment ?>" value="<?php echo $payment ?>">
                <label for="<?php echo $payment ?>"><?php echo $icon ?></label>
              </div>
              <?php }?>
            </div>

            <div class="">
                  <input type="text" name="name"  placeholder="Name on card" required>
            </div>

            <div class="">
                  <input type="text" name="card_no"  placeholder="Card number" required>
            </div>

            <div class="d-flex">
                  <input type="text" name="expired_date" placeholder="Expired date" required>
                  <input type="text" name="security_code" placeholder="Security code" required>
            </div>

            <div class="">
                  <input type="text" name="zip_code"  placeholder="ZIP/Postal code" required>
            </div>
            
            <div class="d-flex">
              <button type="submit" class="w-100 mt-2" name="checkout">
                Checkout Now
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->


<?php

include 'includes/footer.php';

?>