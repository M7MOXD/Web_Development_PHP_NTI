<?php
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./helpers/checkLogin.php";
$user_id = $_SESSION['user']['user_id'];
$sql = "UPDATE orders SET status='Complete' WHERE status='Active' AND user_id=$user_id";
$op = runQuery($sql);
$sql = "INSERT INTO orders (status, user_id) VALUES ('Active', $user_id)";
$op = runQuery($sql);
header('location: '.url(""))
?>