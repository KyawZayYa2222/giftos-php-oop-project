<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/header.php';

use App\Helper\MediaAsset;
use Rakit\Validation\Validator;
use App\Controller\UserController;
use App\Helper\Auth;

// auth check 
if(Auth::check()) {
    header("Location: index.php");
    exit();
}


if (isset($_POST['register'])) {
    $validator = new Validator();

    $validation = $validator->validate($_POST, [
        'name' => 'required|min:2|max:100',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
    ]);

    if($validation->fails())  {
        $errors = $validation->errors();
    } else {
        $userController = new UserController();

        // email exist check 
        $emailExistCheck = $userController->checkEmailExist($_POST['email']);
        if(!$emailExistCheck) {
            $userController->register($_POST);
        } else {
            $validation->errors()->add('email', 'email_check', 'User email alerady existed.');
            $errors = $validation->errors();
        }
    }

}

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

                    <p>Register your account.</p>
                    
                    <!-- <div class="login_section"> -->
                    <form action="" method="POST">
                        <!-- name  -->
                        <div class="">
                        <?php
                        if(isset($errors) && $nameErr = $errors->first('name')) {
                            echo "<small class='text-danger'>$nameErr</small>";
                        }
                        ?>
                            <input type="text" name="name" 
                            class="<?php if(isset($errors) && $nameErr = $errors->first('name')) {echo 'border-danger';} ?>" 
                            placeholder="Username">
                        </div>

                        <!-- email  -->
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

                        <div class="">
                        <?php
                        if(isset($errors) && $passErr = $errors->first('password')) {
                            echo "<small class='text-danger'>$passErr</small>";
                        }
                        ?>
                            <input type="password" name="password" 
                            class="<?php if(isset($errors) && $passErr = $errors->first('password')) {echo 'border-danger';} ?>" 
                            placeholder="Password">
                        </div>

                        <div class="">
                        <?php
                        if(isset($errors) && $passErr = $errors->first('confirm_password')) {
                            echo "<small class='text-danger'>$passErr</small>";
                        }
                        ?>
                            <input type="password" name="confirm_password" 
                            class="<?php if(isset($errors) && $passErr = $errors->first('confirm_password')) {echo 'border-danger';} ?>" 
                            placeholder="Confirm Password">
                        </div>

                        <div class="d-flex">
                            <button type="submit" name="register">Register</button>
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