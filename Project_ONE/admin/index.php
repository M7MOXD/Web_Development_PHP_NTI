<?php
$pageTitle = "Home Page";
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./helpers/checkLogin.php";
$user_id = $_SESSION['user']['user_id'];
$sql = "SELECT * FROM users INNER JOIN roles ON users.role_id = roles.role_id";
$users_op = runQuery($sql);
$sql = "SELECT * FROM roles";
$roles_op = runQuery($sql);
$sql = "SELECT products.*, users.name as user, categories.title as category FROM products INNER JOIN users ON users.user_id = products.addBy INNER JOIN categories ON categories.category_id = products.category_id";
if ($_SESSION['user']['title'] === "Seller") {
    $sql = "SELECT products.*, users.name as user, categories.title as category FROM products INNER JOIN users ON users.user_id = products.addBy INNER JOIN categories ON categories.category_id = products.category_id WHERE products.addBy = $user_id";
}
$products_op = runQuery($sql);
$sql = "SELECT * FROM categories";
$categories_op = runQuery($sql);
require_once "./layouts/header.php";
require_once "./layouts/nav.php";
require_once "./layouts/sideNav.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php echo $pageTitle; ?></li>
            </ol>
            <div class="row">
                <?php
                if (count($modules) > 1) {
                ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Users</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo url("users"); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Roles</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo url("roles"); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Products</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo url("products"); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Categories</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo url("categories"); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-xl-12 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Products</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo url("products"); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <?php
            if (count($modules) > 1) {
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Users
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Controls</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while ($data = mysqli_fetch_assoc($users_op)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['user_id']; ?></td>
                                            <td><img width="50" height="50" src="users/uploads/<?php echo $data['user_img']; ?>"></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['email']; ?></td>
                                            <td><?php echo $data['phone']; ?></td>
                                            <td><?php echo $data['title']; ?></td>
                                            <td>
                                                <a href='users/update.php?id=<?php echo $data['user_id']; ?>' class='btn btn-primary'>Edit</a>
                                                <a href='users/delete.php?id=<?php echo $data['user_id']; ?>' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Roles
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Controls</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while ($data = mysqli_fetch_assoc($roles_op)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['role_id']; ?></td>
                                            <td><?php echo $data['title']; ?></td>
                                            <td>
                                                <a href='roles/update.php?id=<?php echo $data['role_id']; ?>' class='btn btn-primary'>Edit</a>
                                                <a href='roles/delete.php?id=<?php echo $data['role_id']; ?>' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Products
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Added BY</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Added BY</th>
                                        <th>Controls</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while ($data = mysqli_fetch_assoc($products_op)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['product_id']; ?></td>
                                            <td><img width="50" height="50" src="products/uploads/<?php echo $data['product_img']; ?>"></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['description']; ?></td>
                                            <td>$<?php echo $data['price']; ?>.00</td>
                                            <td><?php echo $data['category']; ?></td>
                                            <td><?php echo $data['user']; ?></td>
                                            <td>
                                                <a href='products/update.php?id=<?php echo $data['product_id']; ?>' class='btn btn-primary'>Edit</a>
                                                <a href='products/delete.php?id=<?php echo $data['product_id']; ?>' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Categories
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Controls</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while ($data = mysqli_fetch_assoc($categories_op)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['category_id']; ?></td>
                                            <td><?php echo $data['title']; ?></td>
                                            <td>
                                                <a href='categories/update.php?id=<?php echo $data['category_id']; ?>' class='btn btn-primary'>Edit</a>
                                                <a href='categories/delete.php?id=<?php echo $data['category_id']; ?>' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Products
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Added BY</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Added BY</th>
                                        <th>Controls</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while ($data = mysqli_fetch_assoc($products_op)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['product_id']; ?></td>
                                            <td><img width="50" height="50" src="products/uploads/<?php echo $data['product_img']; ?>"></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['description']; ?></td>
                                            <td>$<?php echo $data['price']; ?>.00</td>
                                            <td><?php echo $data['category']; ?></td>
                                            <td><?php echo $data['user']; ?></td>
                                            <td>
                                                <?php
                                                if ($_SESSION['user']['title'] === "Admin" || $_SESSION['user']['title'] === "Seller") {
                                                ?>
                                                    <a href='products/update.php?id=<?php echo $data['product_id']; ?>' class='btn btn-primary'>Edit</a>
                                                    <a href='products/delete.php?id=<?php echo $data['product_id']; ?>' class='btn btn-danger'>Delete</a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href='<?php echo url(""); ?>addcart.php?id=<?php echo $data['product_id']; ?>' class='btn btn-primary'>Add To Cart</a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </main>
    <?php
    require_once "./layouts/footer.php";
    ?>