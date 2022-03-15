<?php
    require_once "dbConnection.php";
    $id = $_GET["id"];
    $sql = "SELECT * FROM articles WHERE id=$id";
    $op = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($op);
    $sql = "DELETE FROM articles WHERE id=$id";
    $op = mysqli_query($connect, $sql);
    mysqli_close($connect);
    if ($op) {
        $message = "Row Deleted";
        $_SESSION["message"] = $message;
        unlink($data["image"]);
        header("location: articles.php");
    } else {
        echo "Error: Try Again".mysqli_error($connect);
    }
?>