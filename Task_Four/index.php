<?php
    function clean($input) {
        $result = trim($input);
        $result = strip_tags($result);
    };
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $address = $_POST["address"];
        $linkedin = $_POST["linkedin"];
        $gender = isset($_POST["gender"]) ? $_POST["gender"] : false;
        $cv = $_FILES["cv"];
        $errors = [];
        if (!$name) {
            $errors["name"] = "Name is Required";
        } elseif (!ctype_alpha($name)) {
            $errors["name"] = "Name must be String";
        }
        if (!$email) {
            $errors["email"] = "Email is Required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid Email";
        }
        if (!$password) {
            $errors["password"] = "Password is Required";
        } elseif (strlen($password) < 6) {
            $errors["password"] = "Password Length Must be more than 6 Character";
        }
        if (!$address) {
            $errors["address"] = "Address is Required";
        } elseif (strlen($address) > 10) {
            $errors["address"] = "Address Length Must be less than 10 Character";
        }
        if (!$linkedin) {
            $errors["linkedin"] = "Linkedin is Required";
        } elseif (!filter_var($linkedin, FILTER_VALIDATE_URL)) {
            $errors["linkedin"] = "Invalid URL";
        }
        if (!$gender) {
            $errors["gender"] = "Gender is Required";
        }
        if (!$cv["name"]) {
            $errors["cv"] = "File is Required";
        } else {
            $cvName = $cv["name"];
            $cvTempName = $cv["tmp_name"];
            $cvType = $cv["type"];
            $allowExtensions = ["pdf"];
            $cvArray = explode("/", $cvType);
            $cvExtensions = end($cvArray);
            if (in_array($cvExtensions, $allowExtensions)) {
                $cvFinalName = time().rand().".".$cvExtensions;
                $distPath = "uploads/".$cvFinalName;
                if (!move_uploaded_file($cvTempName, $distPath)) {
                    $errors["cv"] = "Error Try Again";
                }
            } else {
                $errors["cv"] = "Invalid Extension";
            }
        }
        if (count($errors) > 0 ) {
            foreach ($errors as $key => $value) {
                echo '* '.$key.' : '.$value.'<br>';
            }
        } else {
            echo "Welcome ".$name." Your Email is: ".$email." and Your address is: ".$address." and Your Linkedin Profile URL is: ".$linkedin." and Your CV uploaded successfully";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <title>Sign Up Form</title>
    </head>
    <body>
        <form class="row g-3 container mx-auto" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" name="name">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" name="email">
            </div>
            <div class="col-md-6">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="password">
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" name="address">
            </div>
            <div class="col-md-12">
                <label for="inputLinkedin" class="form-label">Linkedin</label>
                <input type="text" class="form-control" id="inputLinkedin" name="linkedin">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="Male" value="Male">
                <label class="form-check-label" for="Male">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="Female" value="Female">
                <label class="form-check-label" for="Female">
                    Female
                </label>
            </div>
            <div class="col-md-12">
                <label for="formFile" class="form-label">CV</label>
                <input class="form-control" type="file" id="formFile" name="cv">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </form>
    </body>
</html>