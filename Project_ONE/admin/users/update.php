<?php
    $pageTitle = "User Update Page";
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    require_once "../helpers/checkAdmin.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $op  = runQuery($sql);
    $data = mysqli_fetch_assoc($op);
    $sql = "SELECT * FROM roles";
    $role_op = runQuery($sql);
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $errors = [];
        $name = clean($_POST['name']);
        $email = clean($_POST['email']);
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
        if (!validation($phone, "required")) {
            $errors['phone'] = "Field Required";
        } elseif (!validation($phone, "phone")) {
            $errors['phone'] = "Invalid Phone Number";
        }
        if (!validation($role, "required")) {
            $errors['role'] = "Field Required";
        }
        if (validation($_FILES['image']['name'], "required")) {
            if (!validation($_FILES["image"], "image")) {
                $errors['image'] = "Invalid Image Format";
            }
        }
        if (count($errors) > 0) {
            $_SESSION['message'] = $errors;
        } else {
            if (validation($_FILES['image']['name'], "required")) {
                $image = upload($_FILES['image']);
                unlink('uploads/'.$data['user_img'] );
            } else {
                $image = $data['user_img'];
            }
            $sql = "UPDATE users SET name='$name', email='$email', role_id=$role, phone='$phone', user_img='$image' WHERE user_id=$id";
            $op = runQuery($sql);
            if ($op) {
                $message = ["op" => "Row Inserted"];
            } else {
                $message = ["op" => "Error Try Again"];
            }
            $_SESSION['message'] = $message;
            header('location: '.url("users"));
            exit();
        }
    }
    require_once "../layouts/header.php";
    require_once "../layouts/nav.php";
    require_once "../layouts/sideNav.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php echo $pageTitle; ?></li>
            </ol>
            <form class="needs-validation" novalidate method="POST" action="update.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">Name</label>
                        <input type="text" class="form-control" id="validationCustom01" required name="name" value="<?php echo $data['name']; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Field Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['name'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['name'].'</div>';
                                unset($_SESSION['message']['name']);
                            }
                        ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">Email</label>
                        <input type="email" class="form-control" id="validationCustom02" required name="email" value="<?php echo $data['email']; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Field Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['email'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['email'].'</div>';
                                unset($_SESSION['message']['email']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom04">Role</label>
                        <select class="custom-select" id="validationCustom04" required name="role">
                            <option selected disabled value="">Choose...</option>
                            <?php
                            while ($role_data = mysqli_fetch_assoc($role_op)) {
                            ?>
                            <option value="<?php echo $role_data['role_id']; ?>" <?php if ($role_data['role_id'] === $data['role_id']) { echo "selected"; }; ?> ><?php echo $role_data['title']; ?></option>
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
                                echo '<div class="text-danger small">'.$_SESSION['message']['role'].'</div>';
                                unset($_SESSION['message']['role']);
                            }
                        ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom05">Phone</label>
                        <input type="text" class="form-control" id="validationCustom05" required name="phone" value="<?php echo $data['phone']; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Field Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['phone'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['phone'].'</div>';
                                unset($_SESSION['message']['phone']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="image">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            File Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['image'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['image'].'</div>';
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
    </main>
    <?php
    require_once "../layouts/footer.php";
    ?>