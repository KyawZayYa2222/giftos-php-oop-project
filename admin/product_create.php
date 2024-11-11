<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include_once './vendor/autoload.php';
include './includes/header.php';

use App\Controller\CategoryController;
use App\Controller\ProductController;
use Rakit\Validation\Validator;
use App\Helper\Auth;


$_SESSION['admin_current_page'] = 'product_create';

$categoryController = new CategoryController();
$categories = $categoryController->all();

if (isset($_POST['product_create'])) {
    $validator = new Validator();

    $validation = $validator->validate($_POST + $_FILES, [
        'category_id' => 'required|integer',
        'name' => 'required|min:2|max:100',
        'price' => 'required|numeric',
        'qty' => 'required|integer',
        'image' => 'nullable|uploaded_file:0,1024k,png,jpeg,jpg,gif,svg',
    ]);

    if($validation->fails())  {
        $errors = $validation->errors();
    } else {
        // check category exist 
        $category = $categoryController->find($_POST['category_id']);
        if($category->num_rows > 0) {
            $productController = new ProductController();
            $productController->store($_POST, $_FILES);
        } else {
            $validation->errors()->add('category_id', 'category_exist', 'Category does not exist');
            $errors = $validation->errors();
        }
    }

}
?>



<div id="wrapper">
<?php
include './includes/sidebar.php';
?>


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
    <h1 class="h3 text-gray-800">Product</h1>
    <!-- <button type="submit" name="category_create" class="btn btn-primary">Create</button> -->
</div>

<!-- DataTales Example -->
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            Product Create Form
        </div>
        <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col col-12 col-md-6">
                        <label for="category_id">Category</label>
                        <select class="select-2 form-control <?php if(isset($errors) && $categoryErr = $errors->first('category_id')) {echo 'is-invalid';} ?>" id="category_id" name="category_id">
                        <option value="">Choose category</option>
                        <?php
                        foreach ($categories as $key => $category) {
                            echo "<option value='{$category['id']}'>{$category['name']}</option>";
                        }
                        ?>
                        </select>
                        <?php
                        if(isset($errors) && $categoryErr = $errors->first('category_id')) {
                            echo "<div class='invalid-feedback'> $categoryErr </div>";
                        }
                        ?>
                    </div>

                    <div class="form-group col col-md-6">
                        <label for="name">Product Name</label>
                        <input class="form-control <?php if(isset($errors) && $nameErr = $errors->first('name')) {echo 'is-invalid';} ?>" 
                            name="name" id="name" type="text" placeholder="Product Name" aria-label="default input example">
                        <?php
                        if(isset($errors) && $nameErr = $errors->first('name')) {
                            echo "<div class='invalid-feedback'> $nameErr </div>";
                        }
                        ?>
                    </div>

                    <div class="form-group col col-md-6">
                        <label for="price">Price</label>
                        <input class="form-control <?php if(isset($errors) && $priceErr = $errors->first('price')) {echo 'is-invalid';} ?>" 
                            name="price" id="price" type="number" placeholder="Price" aria-label="default input example">
                        <?php
                        if(isset($errors) && $priceErr = $errors->first('price')) {
                            echo "<div class='invalid-feedback'> $priceErr </div>";
                        }
                        ?>
                    </div>

                    <div class="form-group col col-md-6">
                        <label for="qty">Quantity</label>
                        <input class="form-control <?php if(isset($errors) && $qtyErr = $errors->first('qty')) {echo 'is-invalid';} ?>" 
                            name="qty" id="qty" type="number" placeholder="Quantity" aria-label="default input example">
                        <?php
                        if(isset($errors) && $qtyErr = $errors->first('qty')) {
                            echo "<div class='invalid-feedback'> $qtyErr </div>";
                        }
                        ?>
                    </div>

                    <div class="col px-2">
                    <label for="haha">Product Image</label>
                    <div class="custom-file mb-3">
                        <input type="file" name="image"
                        class="custom-file-input <?php if(isset($errors) && $imgErr = $errors->first('image')) {echo 'is-invalid';} ?>" 
                        id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <?php
                        if(isset($errors) && $imgErr = $errors->first('image')) {
                            echo "<div class='invalid-feedback'> $imgErr </div>";
                        }
                        ?>
                    </div>
                    </div>
                    
                </div>

                <button type="submit" name="product_create" class="btn btn-success float-right">Create</button>
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