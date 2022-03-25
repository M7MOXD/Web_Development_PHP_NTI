<?php
$pageTitle = "Login";
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./layouts/header.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errors = [];
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    if (!validation($email, "required")) {
        $errors['email'] = "Field Required";
    } elseif (!validation($email, "email")) {
        $errors['email'] = "Invalid Email";
    }
    if (!validation($password, "required")) {
        $errors['password'] = "Field Required";
    } elseif (!validation($password, "length")) {
        $errors['password'] = "Password Length must be more than 6 character";
    }
    if (count($errors) > 0) {
        $_SESSION['message'] = $errors;
    } else {
        $password = md5($password);
        $sql = "SELECT * FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE users.email = '$email' AND users.password = '$password'";
        $op = runQuery($sql);
        if (mysqli_num_rows($op) == 1) {
            $data = mysqli_fetch_assoc($op);
            $_SESSION['user'] = $data;
            $message = ["op" => "Welcome Back"];
        } else {
            $message = ["op" => "Error Try Again"];
        }
        $_SESSION['message'] = $message;
        header('location: '.baseUrl(""));
        exit();
    }
}
?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Login</h3>
                                <p class="text-center font-weight-light my-4">
                                <?php
                                    if (isset($_SESSION['message']['op'])) {
                                        echo $_SESSION['message']['op'];
                                        unset($_SESSION['message']['op']);
                                    }
                                ?>
                                </p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address" name="email"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name="password"/>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Login</button>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php
    require_once "./layouts/footer.php";
    ?>