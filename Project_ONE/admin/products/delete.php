<?php
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    $user_id = $_SESSION['user']['user_id'];
    if ($_SESSION['user']['title'] === "Customer") {
        header('location: '.url(""));
        exit();
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = $id";
    $op = runQuery($sql);
    $data = mysqli_fetch_assoc($op);
    if ($_SESSION['user']['title'] === "Seller") {
        if ($user_id !== $data['addBy']) {
            header('location: '.url(""));
            exit();
        }
    }
    $sql = "DELETE FROM products WHERE product_id = $id";
    $op = runQuery($sql);
    if ($op) {
        unlink("uploads/".$data['product_img']);
        $message = ["op" => "Raw Removed"];
    } else {
        $message = ["op" => "Error Try Again"];
    }
    $_SESSION['message'] = $message;
    header('location: '.url("products"));
    exit();
?>