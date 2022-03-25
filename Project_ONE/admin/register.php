<?php
$pageTitle = "Register";
require_once "./helpers/dbConnection.php";
require_once "./helpers/functions.php";
require_once "./layouts/header.php";
$sql = "SELECT * FROM roles";
$role_op = runQuery($sql);
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errors = [];
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $role = clean($_POST['role']);
    $phone = clean($_POST['phone']);
    if (!validation($name, "required")) {
        $errors['name'] = "Field Required";
    } elseif (!validation($name, "string")) {
        $errors['name'] = "Invalid Name";
    }
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
    if (!validation($phone, "required")) {
        $errors['phone'] = "Field Required";
    } elseif (!validation($phone, "phone")) {
        $errors['phone'] = "Invalid Phone Number";
    }
    if (!validation($role, "required")) {
        $errors['role'] = "Field Required";
    }
    if (!validation($_FILES['image']['name'], "required")) {
        $errors['image'] = "File Required";
    } elseif (!validation($_FILES["image"], "image")) {
        $errors['image'] = "Invalid Image Format";
    }
    if (count($errors) > 0) {
        $_SESSION['message'] = $errors;
    } else {
        $image = uploadRegister($_FILES['image']);
        $password = md5($password);
        $sql = "INSERT INTO users (name, email, password, role_id, phone, user_img) VALUES ('$name', '$email', '$password', $role, '$phone', '$image')";
        $op = runQuery($sql);
        if ($op) {
            $message = ["op" => "Row Inserted"];
        } else {
            $message = ["op" => "Error Try Again"];
        }
        $_SESSION['message'] = $message;
        $sql = "SELECT * FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE users.email = '$email' AND users.password = '$password'";
        $op = runQuery($sql);
        $data = mysqli_fetch_assoc($op);
        $user_id = $data['user_id'];
        $sql = "INSERT INTO orders (status, user_id) VALUES ('Active', $user_id)";
        $op = runQuery($sql);
        $sql = "SELECT * FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE users.user_id = $user_id";
        $op = runQuery($sql);
        if (mysqli_num_rows($op) == 1) {
            $data = mysqli_fetch_assoc($op);
            $_SESSION['user'] = $data;
            $message = ["op" => "Welcome Back"];
        } else {
            $message = ["op" => "Error Try Again"];
        }
        $_SESSION['message'] = $message;
        header('location: ' . url(""));
        exit();
    }
}
?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Create Account</h3>
                            </div>
                            <div class="card-body">
                                <form class="needs-validation" novalidate method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Name</label>
                                            <input type="text" class="form-control" id="validationCustom01" required name="name">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Field Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['name'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['name'] . '</div>';
                                                unset($_SESSION['message']['name']);
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Email</label>
                                            <input type="email" class="form-control" id="validationCustom02" required name="email">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Field Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['email'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['email'] . '</div>';
                                                unset($_SESSION['message']['email']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Password</label>
                                            <input type="password" class="form-control" id="validationCustom03" required name="password">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Field Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['password'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['password'] . '</div>';
                                                unset($_SESSION['message']['password']);
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Role</label>
                                            <select class="custom-select" id="validationCustom04" required name="role">
                                                <option selected disabled value="">Choose...</option>
                                                <?php
                                                while ($data = mysqli_fetch_assoc($role_op)) {
                                                    if ($data['role_id'] == 1) {
                                                        continue;
                                                    }
                                                ?>
                                                    <option value="<?php echo $data['role_id']; ?>"><?php echo $data['title']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Field Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['role'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['role'] . '</div>';
                                                unset($_SESSION['message']['role']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom05">Phone</label>
                                            <input type="text" class="form-control" id="validationCustom05" required name="phone">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Field Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['phone'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['phone'] . '</div>';
                                                unset($_SESSION['message']['phone']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" id="validatedCustomFile" required name="image">
                                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                File Required!
                                            </div>
                                            <?php
                                            if (isset($_SESSION['message']['image'])) {
                                                echo '<div class="text-danger small">' . $_SESSION['message']['image'] . '</div>';
                                                unset($_SESSION['message']['image']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </form>
                                <script>
                                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                                    (function() {
                                        'use strict';
                                        window.addEventListener('load', function() {
                                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                            var forms = document.getElementsByClassName('needs-validation');
                                            // Loop over them and prevent submission
                                            var validation = Array.prototype.filter.call(forms, function(form) {
                                                form.addEventListener('submit', function(event) {
                                                    if (form.checkValidity() === false) {
                                                        event.preventDefault();
                                                        event.stopPropagation();
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();
                                </script>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="login.html">Have an account? Go to login</a></div>
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