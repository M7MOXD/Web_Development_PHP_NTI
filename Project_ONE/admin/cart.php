<?php
$pageTitle = "Cart Page";
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./helpers/checkLogin.php";
if ($_SESSION['user']['title'] === "Admin" || $_SESSION['user']['title'] === "Seller") {
    header('location: ' . url(""));
    exit();
}
$user_id = $_SESSION['user']['user_id'];
$sql = "SELECT * FROM orders WHERE status='Active' AND user_id=$user_id";
$op = runQuery($sql);
$order_details = mysqli_fetch_assoc($op);
$order_id = $order_details['order_id'];
$sql = "SELECT products.*, users.name as user, categories.title as category, order_products.* FROM products INNER JOIN users ON users.user_id = products.addBy INNER JOIN categories ON categories.category_id = products.category_id INNER JOIN order_products ON products.product_id = order_products.product_id WHERE order_products.order_id=$order_id";
$products_op = runQuery($sql);
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
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Cart Items
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
                                    <th><a href='<?php echo url("complete.php"); ?>' class='btn btn-success'>Check Out</a></th>
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
                                            <a href='<?php echo url(""); ?>delorder.php?id=<?php echo $data['product_id']; ?>' class='btn btn-danger'>Delete From Cart</a>
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
    require_once "./layouts/footer.php";
    ?>