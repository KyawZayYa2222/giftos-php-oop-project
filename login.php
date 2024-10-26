<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/header.php';

use App\Helper\MediaAsset;

?>

<!-- content section  -->
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <!-- <div class="bg-secondary">
        
    </div> -->

    <div class="card mb-3" style="max-width: 960px;">
        <div class="row g-0">
            <div class="col-md-5 p-5 rounded" style="background-color: #6929a5;">
            <img src="<?php echo MediaAsset::assets('images/gifts.png') ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-7">
                <div class="card-body login_section">
                    <h2 class="card-title">
                    <?php echo $_ENV['APP_NAME'] ?>
                    </h2>

                    <p>Login to your account.</p>
                    
                    <!-- <div class="login_section"> -->
                    <form action="" class="">
                        <input type="text" name="name" placeholder="Username">

                        <input type="email" name="email" placeholder="Email">

                        <input type="password" name="password" placeholder="Password">

                        <div class="d-flex">
                        <button>Login</button>
                        </div>
                    </form>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>




<script src="assets/js/jquery-3.4.1.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="assets/js/custom.js"></script>

</body>

</html>