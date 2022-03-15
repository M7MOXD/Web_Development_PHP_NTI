<?php
    session_start();
    $server = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "test";
    $connect = mysqli_connect($server, $dbUser, $dbPassword, $dbName);
    if (!$connect) {
        die("Error: ".mysqli_connect_error());
    }
?>