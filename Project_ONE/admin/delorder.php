<?php
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./helpers/checkLogin.php";
$id = $_GET['id'];
$user_id = $_SESSION['user']['user_id'];
$sql = "SELECT * FROM orders WHERE status='Active' AND user_id=$user_id";
$op = runQuery($sql);
$order_details = mysqli_fetch_assoc($op);
$order_id = $order_details['order_id'];
$sql = "DELETE FROM order_products WHERE order_id=$order_id AND product_id=$id";
$op = runQuery($sql);
$sql = "SELECT * FROM products INNER JOIN order_products ON products.product_id = order_products.product_id WHERE order_products.order_id=$order_id";
$op = runQuery($sql);
$fullOrder = mysqli_fetch_all($op, MYSQLI_ASSOC);
$totalprice = 0;
foreach ($fullOrder as $key => $value) {
    $totalprice += $value['price'] * $value['quantity'];
}
$sql = "UPDATE orders SET total_price=$totalprice WHERE status='Active' AND user_id=$user_id";
$op = runQuery($sql);
header('location: '.url("cart.php"))
?>