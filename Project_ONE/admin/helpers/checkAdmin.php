<?php
    if ($_SESSION['user']['title'] !== 'Admin') {
        header('location: '.url(""));
        exit();
    }
?>