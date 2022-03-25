<?php
$pageTitle = "Products Home Page";
require_once "../helpers/dbConnection.php";
require_once "../helpers/functions.php";
require_once "../helpers/checkLogin.php";
$user_id = $_SESSION['user']['user_id'];
$sql = "SELECT products.*, users.name as user, categories.title as category FROM products INNER JOIN users ON users.user_id = products.addBy INNER JOIN categories ON categories.category_id = products.category_id";
if ($_SESSION['user']['title'] === "Seller") {
    $sql = "SELECT products.*, users.name as user, categories.title as category FROM products INNER JOIN users ON users.user_id = products.addBy INNER JOIN categories ON categories.category_id = products.category_id WHERE products.addBy = $user_id";
}
$op = runQuery($sql);
require_once "../layouts/header.php";
require_once "../layouts/nav.php";
require_once "../layouts/sideNav.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <?php
                if (isset($_SESSION['message']['op'])) {
                    echo '<li class="breadcrumb-item active">' . $_SESSION['message']['op'] . '</li>';
                    unset($_SESSION['message']['op']);
                } else {
                    echo '<li class="breadcrumb-item active">' . $pageTitle . '</li>';
                }
                ?>
            </ol>
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
                                while ($data = mysqli_fetch_assoc($op)) {
                                ?>
                                    <tr>
                                        <td><?php echo $data['product_id']; ?></td>
                                        <td><img width="50" height="50" src="uploads/<?php echo $data['product_img']; ?>"></td>
                                        <td><?php echo $data['name']; ?></td>
                                        <td><?php echo $data['description']; ?></td>
                                        <td>$<?php echo $data['price']; ?>.00</td>
                                        <td><?php echo $data['category']; ?></td>
                                        <td><?php echo $data['user']; ?></td>
                                        <td>
                                            <?php
                                            if ($_SESSION['user']['title'] === "Admin" || $_SESSION['user']['title'] === "Seller") {
                                            ?>
                                                <a href='update.php?id=<?php echo $data['product_id']; ?>' class='btn btn-primary'>Edit</a>
                                                <a href='delete.php?id=<?php echo $data['product_id']; ?>' class='btn btn-danger'>Delete</a>
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
        </div>
    </main>
    <?php
    require_once "../layouts/footer.php";
    ?>