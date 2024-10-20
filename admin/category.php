<?php
include './includes/header.php';

use App\Controller\CategoryController;

session_start();
$_SESSION['admin_current_page'] = 'category';

$categoryController = new CategoryController();   

if (isset($_GET['page'])) {
    $categories = $categoryController->get($_GET['page']);
} else {
    $categories = $categoryController->get();
}

// search 
if(isset($_GET['search'])) {
    $categories = $categoryController->search($_GET['search']);
}

// delete 
if(isset($_POST['delete'])) {
    $categoryController->delete($_POST);
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
    <h1 class="h3 text-gray-800">Category</h1>
    <a href="/admin/category_create.php" class="btn btn-primary">Create</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
         <form method="GET"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-1 small" 
                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                value="<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Category</th>
                        <th width="240px">Actions</th>
                    </tr>
                </thead>
                <tbody>

<?php
    foreach ($categories['data'] as $key => $category) {
        $no = $key + 1;
        $id = $category['id'];
        $name = $category['name'];
        echo "<tr>
                <td>$no</td>
                <td>$name</td>
                <td>
                <div class='d-flex'>
                    <a href='/admin/category_edit.php?id=$id&&name=$name' class='btn btn-sm btn-primary mr-2'>Edit</a>
                    <form method='POST'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>
                    </form>
                </div>
                </td>
            </tr>";
    }

?>
                    
                    
                </tbody>
            </table>

        <?php 
        if(isset($categories['link'])) {
            echo $categories['link'];
        }
        ?>

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