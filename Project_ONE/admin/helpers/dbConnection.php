<?php
    session_start();
    $server = "localhost";
    $dbName = "test";
    $dbUser = "root";
    $dbPassword= "";
    $con = mysqli_connect($server, $dbUser, $dbPassword, $dbName);
?>