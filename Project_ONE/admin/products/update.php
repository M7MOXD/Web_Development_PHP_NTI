<?php
    $pageTitle = "Product Update Page";
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    $user_id = $_SESSION['user']['user_id'];
    if ($_SESSION['user']['title'] === "Customer") {
        header('location: '.url(""));
        exit();
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = $id";
    $op  = runQuery($sql);
    $data = mysqli_fetch_assoc($op);
    if ($_SESSION['user']['title'] === "Seller") {
        if ($user_id !== $data['addBy']) {
            header('location: '.url(""));
            exit();
        }
    }
    $sql = "SELECT * FROM categories";
    $category_op = runQuery($sql);
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $errors = [];
        $name = clean($_POST['name']);
        $description = clean($_POST['description']);
        $price = clean($_POST['price']);
        $category = clean($_POST['category']);
        if (!validation($name, "required")) {
            $errors['name'] = "Field Required";
        } elseif (!validation($name, "string")) {
            $errors['name'] = "Invalid Name";
        }
        if (!validation($description, "required")) {
            $errors['description'] = "Field Required";
        } elseif (!validation($description, "string")) {
            $errors['description'] = "Invalid Description";
        }
        if (!validation($price, "required")) {
            $errors['price'] = "Field Required";
        } elseif (!validation($price, "number")) {
            $errors['price'] = "Price must be Number";
        }
        if (!validation($category, "required")) {
            $errors['category'] = "Field Required";
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
                unlink('uploads/'.$data['product_img'] );
            } else {
                $image = $data['product_img'];
            }
            $sql = "UPDATE products SET name='$name', description='$description', price=$price, category_id='$category', product_img='$image' WHERE product_id=$id";
            $op = runQuery($sql);
            if ($op) {
                $message = ["op" => "Row Inserted"];
            } else {
                $message = ["op" => "Error Try Again"];
            }
            $_SESSION['message'] = $message;
            header('location: '.url("products"));
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
                        <label for="validationCustom02">Description</label>
                        <input type="text" class="form-control" id="validationCustom02" required name="description" value="<?php echo $data['description']; ?>">
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
                        <label for="validationCustom03">Price</label>
                        <input type="text" class="form-control" id="validationCustom03" required name="price" value="<?php echo $data['price']; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Field Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['password'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['password'].'</div>';
                                unset($_SESSION['message']['password']);
                            }
                        ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom04">Category</label>
                        <select class="custom-select" id="validationCustom04" required name="category">
                            <option selected disabled value="">Choose...</option>
                            <?php
                            while ($category_data = mysqli_fetch_assoc($category_op)) {
                            ?>
                            <option value="<?php echo $category_data['category_id']; ?>" <?php if ($category_data['category_id'] === $data['category_id']) { echo "selected"; }; ?> ><?php echo $category_data['title']; ?></option>
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