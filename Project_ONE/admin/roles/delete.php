<?php
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    require_once "../helpers/checkAdmin.php";
    $id = $_GET['id'];
    $sql = "DELETE FROM roles WHERE role_id = $id";
    $op = runQuery($sql);
    if ($op) {
        $message = ["op" => "Raw Removed"];
    } else {
        $message = ["op" => "Error Try Again"];
    }
    $_SESSION['message'] = $message;
    header('location: '.url("roles"));
    exit();
?>