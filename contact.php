<?php
error_reporting(1);

include 'includes/header.php';

use Rakit\Validation\Validator;
use App\Controller\ContactController;

$_SESSION['currentpage'] = "contact";

if (isset($_POST['contact_create'])) {
  $validator = new Validator();

  $validation = $validator->validate($_POST, [
      'name' => 'required|max:100',
      'email' => 'required|email',
      'phone' => 'required|min:7|max:20',
      'message' => 'required|min:2|max:255',
  ]);

  if($validation->fails()) {
      $errors = $validation->errors();
  } else {
    $contactController = new ContactController();
    $result = $contactController->store($_POST);
    echo $result;
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
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <form action="#" method="POST">
            <!-- <div>
              <input type="text" placeholder="Name" />
            </div> -->
            <!-- Name  -->
            <div class="">
              <?php
              if(isset($errors) && $nameErr = $errors->first('name')) {
                  echo "<small class='text-danger'>$nameErr</small>";
              }
              ?>
                  <input type="text" name="name" 
                  class="<?php if(isset($errors) && $nameErr = $errors->first('name')) {echo 'border-danger';} ?>" 
                  placeholder="Name">
            </div>

            <!-- Email  -->
            <div class="">
              <?php
              if(isset($errors) && $emailErr = $errors->first('email')) {
                  echo "<small class='text-danger'>$emailErr</small>";
              }
              ?>
                  <input type="email" name="email" 
                  class="<?php if(isset($errors) && $emailErr = $errors->first('email')) {echo 'border-danger';} ?>" 
                  placeholder="Email">
            </div>

            <!-- Message  -->
            <div class="">
              <?php
              if(isset($errors) && $phoneErr = $errors->first('phone')) {
                  echo "<small class='text-danger'>$phoneErr</small>";
              }
              ?>
                  <input type="text" name="phone" 
                  class="<?php if(isset($errors) && $phoneErr = $errors->first('phone')) {echo 'border-danger';} ?>" 
                  placeholder="Phone">
            </div>

            <!-- Message  -->
            <div class="">
              <?php
              if(isset($errors) && $mesgErr = $errors->first('message')) {
                  echo "<small class='text-danger'>$mesgErr</small>";
              }
              ?>
                  <input type="text" name="message" 
                  class="message-box <?php if(isset($errors) && $mesgErr = $errors->first('message')) {echo 'border-danger';} ?>" 
                  placeholder="Message">
            </div>
            <div class="d-flex ">
              <button type="submit" name="contact_create">
                SEND
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