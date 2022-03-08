<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!$_POST["name"]) {
            echo "Name is Required";
            return;
        } elseif (!ctype_alpha($_POST["name"])) {
            echo "Name must be String";
            return;
        }
        if (!$_POST["email"]) {
            echo "Email is Required";
            return;
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo "Invalid Email";
            return;
        }
        if (!$_POST["password"]) {
            echo "Password is Required";
            return;
        } elseif (strlen($_POST["password"]) < 6) {
            echo "Password Length Must be more than 6 Character";
            return;
        }
        if (!$_POST["address"]) {
            echo "Address is Required";
            return;
        } elseif (strlen($_POST["address"]) > 10) {
            echo "Address Length Must be less than 10 Character";
            return;
        }
        if (!$_POST["linkedin"]) {
            echo "Linkedin is Required";
            return;
        } elseif (!filter_var($_POST["linkedin"], FILTER_VALIDATE_URL)) {
            echo "Invalid URL";
            return;
        }
    }
?>