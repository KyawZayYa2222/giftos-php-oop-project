<?php
// use App\Helper\Auth;
// use Rakit\Validation\Validator;
// use App\Controller\UserController;

?>

<nav>
    <ul class="p-0 m-0">
        <li class="mx-auto active-nav" style="background-color: white !important;">
        <a href="profile.php?active-section=edit" class="text-dark">Edit Profile</a>
        </li>
        <li class="mx-auto">
        <a href="profile.php?active-section=change-password">Change Password</a>
        </li>
        <li class="mx-auto">
        <a href="profile.php?active-section=invoices">Invoices</a>
        </li>
    </ul>
</nav>

<!-- <h6 class="p-3">Update your profile details.</h6> -->

<form action="" enctype="multipart/form-data" method="POST">
    <div class="">
        <?php
        if(isset($errors) && $imageErr = $errors->first('image')) {
            echo "<small class='text-danger'>$imageErr</small>";
        }
        ?>
            <input type="file" name="image" 
            class="file-input <?php if(isset($errors) && $imageErr = $errors->first('image')) {echo 'border-danger';} ?>">
    </div>

    <div class="">
        <?php
        if(isset($errors) && $nameErr = $errors->first('name')) {
            echo "<small class='text-danger'>$nameErr</small>";
        }
        ?>
            <input type="text" name="name" value="<?php echo $user->name;?>" 
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
            <input type="email" name="email"  value="<?php echo $user->email;?>" 
            class="<?php if(isset($errors) && $emailErr = $errors->first('email')) {echo 'border-danger';} ?>" 
            placeholder="Email">
    </div>

    <!-- Message  -->
    <div class="">
        <?php
        if(isset($errors) && $mesgErr = $errors->first('shipping_address')) {
            echo "<small class='text-danger'>$mesgErr</small>";
        }
        ?>
            <input type="text" name="shipping_address"  value="<?php echo $user->shipping_address;?>" 
            class="message-box <?php if(isset($errors) && $mesgErr = $errors->first('shipping_address')) {echo 'border-danger';} ?>" 
            placeholder="Shipping Address">
    </div>
    <div class="d-flex">
        <button type="submit" name="profile_update">
        Update Profile Details
        </button>
    </div>
</form>