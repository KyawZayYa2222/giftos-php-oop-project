<nav>
    <ul class="p-0 m-0">
        <li class="mx-auto">
        <a href="profile.php?active-section=edit">Edit Profile</a>
        </li>
        <li class="mx-auto active-nav" style="background-color: white !important;">
        <a href="profile.php?active-section=change-password" class="text-dark">Change Password</a>
        </li>
        <li class="mx-auto">
        <a href="profile.php?active-section=invoices">Invoices</a>
        </li>
    </ul>
</nav>


<form action="" method="POST">
    <!-- message  -->
    <?php
        if(isset($result) && $result['success'] === false) {
            echo "<p class='text-danger mb-2'>". $result['message'] ."</p>";
        }
    ?>

    <div class="">
        <?php
        if(isset($errors) && $passErr = $errors->first('old_password')) {
            echo "<small class='text-danger'>$passErr</small>";
        }
        ?>
            <input type="password" name="old_password" 
            class="<?php if(isset($errors) && $passErr = $errors->first('old_password')) {echo 'border-danger';} ?>" 
            placeholder="Old Password">
    </div>

    <div class="">
    <?php
    if(isset($errors) && $passErr = $errors->first('new_password')) {
        echo "<small class='text-danger'>$passErr</small>";
    }
    ?>
        <input type="password" name="new_password" 
        class="<?php if(isset($errors) && $passErr = $errors->first('new_password')) {echo 'border-danger';} ?>" 
        placeholder="New Password">
    </div>

    <div class="">
    <?php
    if(isset($errors) && $passErr = $errors->first('confirm_new_password')) {
        echo "<small class='text-danger'>$passErr</small>";
    }
    ?>
        <input type="password" name="confirm_new_password" 
        class="<?php if(isset($errors) && $passErr = $errors->first('confirm_new_password')) {echo 'border-danger';} ?>" 
        placeholder="Confirm New Password">
    </div>

    <div class="d-flex">
        <button type="submit" name="change_password">Change Password</button>
    </div>
</form>