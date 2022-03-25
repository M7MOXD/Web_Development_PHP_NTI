<?php
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    require_once "../helpers/checkAdmin.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $op = runQuery($sql);
    $data = mysqli_fetch_assoc($op);
    $sql = "DELETE FROM users WHERE user_id = $id";
    $op = runQuery($sql);
    if ($op) {
        unlink("uploads/".$data['user_img']);
        $message = ["op" => "Raw Removed"];
    } else {
        $message = ["op" => "Error Try Again"];
    }
    $_SESSION['message'] = $message;
    header('location: '.url("users"));
    exit();
?>