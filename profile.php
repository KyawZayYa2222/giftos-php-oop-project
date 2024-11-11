<?php
error_reporting(1);

include 'includes/header.php';

use Rakit\Validation\Validator;
use App\Controller\ContactController;
use App\Helper\Auth;
use App\Helper\MediaAsset;
use App\Controller\UserController;

$_SESSION['currentpage'] = "profile";

// Auth check 
if(!Auth::check()) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['active-section'])) {
  $_SESSION['active-section'] = $_GET['active-section'];
}

// print_r($_SESSION['user']);
$user = Auth::user();
// $user->name ="helo";
// var_dump($user);
// die();

if(isset($_POST['profile_update'])) {
  $validator = new Validator();

  $validation = $validator->validate($_POST + $_FILES, [
      'name' =>'required|min:3|max:100',
      'email' =>'required|email',
      'shipping_address' =>'nullable|max:255',
      'image' => 'nullable|uploaded_file:0,1024k,png,jpeg,svg,jpg,gif'
  ]);

  if($validation->fails()) {
      $errors = $validation->errors();
  } else {
      $userController = new UserController();
      $userController->update($_POST, $_FILES);
      // header("Location: profile.php");
      // exit();  
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
      <!-- <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div> -->
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
                <div class="profile-detail-section">
                    <svg  id="visual" viewBox="0 0 675 900" width="auto" height="auto" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"><rect x="0" y="0" width="675" height="900" fill="#FFFFFF"></rect><path d="M301 900L330.5 862.5C360 825 419 750 414.5 675C410 600 342 525 314.3 450C286.7 375 299.3 300 339.8 225C380.3 150 448.7 75 482.8 37.5L517 0L675 0L675 37.5C675 75 675 150 675 225C675 300 675 375 675 450C675 525 675 600 675 675C675 750 675 825 675 862.5L675 900Z" fill="#FC5579" stroke-linecap="round" stroke-linejoin="miter"></path></svg>
                    <div class="profile-detail-con p-5">
                      <?php
                      if($user->avatar != null && $user->avatar != "" ) {
                        $profileImg = MediaAsset::assets($user->avatar);
                      } else {
                        $profileImg = MediaAsset::assets('images/blank_profile.jpg');
                      }
                      ?>
                        <img src="<?php echo $profileImg; ?>" width="160px" height="160px" alt="">
                        <h3 class="text-secondary my-4"><?php echo $user->name ?></h3>
                        <div class="pt-3">
                        <p class="h6 text-secondary" style="line-height: .3em;">Email</p>
                        <hr style="height:1px; border-none;background-color: #6e6e6e; line-height: 1em;">
                        <p class="text-secondary"><?php echo $user->email ?></p>
                        </div>

                        <div class="pt-3">
                        <p class="h6 text-secondary" style="line-height: .3em;">Shipping Address</p>
                        <hr style="height:1px; border-none;background-color: #6e6e6e; line-height: 1em;">
                        <p class="text-secondary">
                        <?php echo $user->shipping_address ?>
                        </p>
                        </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
        <div class="col-md-6 px-0 profile-action">
          <?php
          $activeSec = $_SESSION['active-section'];
          if ($activeSec == "change-password") {
            include 'includes/change_password.php';
            exit();
          } else if ($activeSec == "invoices") {
            include 'includes/invoices.php';
            exit();
          } else if ($activeSec == "edit"){
            include 'includes/edit_profile.php';
            exit();
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->


<?php

include 'includes/footer.php';

?>