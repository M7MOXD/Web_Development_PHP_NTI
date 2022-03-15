<?php
    require_once "dbConnection.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM articles WHERE id=$id";
    $op = mysqli_query($connect, $sql);
    mysqli_close($connect);
    if ($op) {
        echo "Row Deleted";
        header("location: articles.php");
    } else {
        echo "Error: Try Again".mysqli_error($connect);
    }
?>