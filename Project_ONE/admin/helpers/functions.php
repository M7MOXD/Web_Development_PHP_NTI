<?php
    function clean($input) {
        return trim($input);
    }
    function validation($input, $flag) {
        $status = true;
        switch ($flag) {
            case 'required':
                if (!$input) {
                    $status = false;
                }
                break;
            case 'email':
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $status = false;
                }
                break;
            case 'number':
                if (!filter_var($input, FILTER_VALIDATE_INT)) {
                    $status = false;
                }
                break;
            case 'image':
                $imageType = $input["type"];
                $allowedExtensions = ["png", "jpeg"];
                $imageArray = explode("/", $imageType);
                $imageExtensions = end($imageArray);    
                if (!in_array($imageExtensions, $allowedExtensions)) {
                    $status = false;
                }
                break;
            case 'string':
                if (!preg_match("/^[a-zA-Z\s']*$/",$input)) {
                    $status = false;
                }
                break;
            case 'phone':
                if (!preg_match("/^01[0-2,5][0-9]{8}$/",$input)) {
                    $status = false;
                }
                break;
            case 'length':
                if (strlen($input) < 6) {
                    $status = false;
                }
                break;
        }
        return $status;
    }
    function runQuery($input) {
        $result = mysqli_query($GLOBALS['con'], $input);
        return $result;
    }
    function upload($input) {
        $image = null;
        $imageType = $input["type"];
        $imageArray = explode("/", $imageType);
        $imageExtensions = end($imageArray);
        $imageFinalName = time().rand().".".$imageExtensions;
        $distPath = "uploads/".$imageFinalName;
        $imageTempName = $input["tmp_name"];
        if (move_uploaded_file($imageTempName, $distPath)) {
            $image = $imageFinalName;
        }
        return $image;
    }
    function uploadRegister($input) {
        $image = null;
        $imageType = $input["type"];
        $imageArray = explode("/", $imageType);
        $imageExtensions = end($imageArray);
        $imageFinalName = time().rand().".".$imageExtensions;
        $distPath = "users/uploads/".$imageFinalName;
        $imageTempName = $input["tmp_name"];
        if (move_uploaded_file($imageTempName, $distPath)) {
            $image = $imageFinalName;
        }
        return $image;
    }
    function url($input) {
        return "http://".$_SERVER['HTTP_HOST']."/php/admin/".$input;
    }
    function baseUrl($input) {
        return "http://".$_SERVER['HTTP_HOST']."/php/index.php".$input;
    }
?>