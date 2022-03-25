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
$sql = "SELECT * FROM orders WHERE status='Complete' AND user_id=$user_id";
$op = runQuery($sql);
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
                                    <th>Status</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Total Price</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                while ($data = mysqli_fetch_assoc($op)) {
                                ?>
                                    <tr>
                                        <td><?php echo $data['order_id']; ?></td>
                                        <td><?php echo $data['status']; ?></td>
                                        <td>$<?php echo $data['total_price']; ?>.00</td>
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