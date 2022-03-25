<?php
    $pageTitle = "Role Update Page";
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    require_once "../helpers/checkAdmin.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM roles WHERE role_id = $id";
    $op  = runQuery($sql);
    $data = mysqli_fetch_assoc($op);
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $errors = [];
        $title = clean($_POST['title']);
        if (!validation($title, "required")) {
            $errors['title'] = "Field Required";
        }
        if (count($errors) > 0) {
            $_SESSION['message'] = $errors;
        } else {
            $sql = "UPDATE roles SET title='$title' WHERE role_id=$id";
            $op = runQuery($sql);
            if ($op) {
                $message = ["op" => "Row Updated"];
            } else {
                $message = ["op" => "Error Try Again"];
            }
            $_SESSION['message'] = $message;
            header('location: '.url("roles"));
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
            <form class="needs-validation" novalidate method="POST" action="update.php?id=<?php echo $id;?>">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Title</label>
                        <input type="text" class="form-control" id="validationCustom01" name="title" required value="<?php echo $data['title']; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Field Required!
                        </div>
                        <?php
                            if (isset($_SESSION['message']['title'])) {
                                echo '<div class="text-danger small">'.$_SESSION['message']['title'].'</div>';
                                unset($_SESSION['message']['title']);
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