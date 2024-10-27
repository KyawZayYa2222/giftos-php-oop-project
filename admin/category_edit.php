<?php
// include_once './vendor/autoload.php';
include './includes/header.php';

use App\Controller\CategoryController;
use Rakit\Validation\Validator;
use App\Helper\Auth;

// Auth check 
if(!Auth::check()) {
    header("Location: login.php");
    exit();
}
if(Auth::user()->user_type !== 'admin') {
    header("Location: index.php");
}

$_SESSION['admin_current_page'] = 'category_edit';

if (isset($_POST['category_edit'])) {
    $validator = new Validator();

    $validation = $validator->validate($_POST + $_FILES, [
        'name' => 'required|min:2|max:100',
    ]);

    if($validation->fails())  {
        $errors = $validation->errors();
    } else {
        $categoryController = new CategoryController();
        $categoryController->update($_POST);
    }

}
?>



<div id="wrapper">
<?php
include './includes/sidebar.php';
?>

<!-- <div class='success-alert'>Category created successful.</div> -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<?php
include './includes/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-flex mb-2 justify-content-between">
    <h1 class="h3 text-gray-800">Category</h1>
    <!-- <button type="submit" name="category_edit" class="btn btn-primary">Create</button> -->
</div>

<!-- DataTales Example -->
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            Category Edit Form
        </div>
        <div class="card-body">
                <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <input class="form-control mb-3 <?php if(isset($errors) && $nameErr = $errors->first('name')) {echo 'is-invalid';} ?>" 
                name="name" type="text" placeholder="Category" aria-label="default input example"
                value="<?php echo $_GET['name'] ?>">
                
<?php
if(isset($errors) && $nameErr = $errors->first('name')) {
    echo "<div class='invalid-feedback'> $nameErr </div>";
}
?>

                <button type="submit" name="category_edit" class="btn btn-success float-right">Update</button>
                </form>
        </div>
    </div>
</div>


</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
</div>
</div>
</div>


<?php
include './includes/footer.php';
?>