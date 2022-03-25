<?php
    $pageTitle = "Users Home Page";
    require_once "../helpers/dbConnection.php";
    require_once "../helpers/functions.php";
    require_once "../helpers/checkLogin.php";
    require_once "../helpers/checkAdmin.php";
    $sql = "SELECT * FROM users INNER JOIN roles ON users.role_id = roles.role_id";
    $op = runQuery($sql);
    require_once "../layouts/header.php";
    require_once "../layouts/nav.php";
    require_once "../layouts/sideNav.php";
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <?php
                    if (isset($_SESSION['message']['op'])) {
                        echo '<li class="breadcrumb-item active">'.$_SESSION['message']['op'].'</li>';
                        unset($_SESSION['message']['op']);
                    } else {
                        echo '<li class="breadcrumb-item active">'.$pageTitle.'</li>';
                    }
                ?>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Users
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Controls</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Controls</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                while($data = mysqli_fetch_assoc($op)) {
                                ?>
                                <tr>
                                    <td><?php echo $data['user_id']; ?></td>
                                    <td><img width="50" height="50" src="uploads/<?php echo $data['user_img']; ?>"></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td><?php echo $data['phone']; ?></td>
                                    <td><?php echo $data['title']; ?></td>
                                    <td>
                                        <a href='update.php?id=<?php echo $data['user_id']; ?>' class='btn btn-primary'>Edit</a>
                                        <a href='delete.php?id=<?php echo $data['user_id']; ?>' class='btn btn-danger'>Delete</a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    require_once "../layouts/footer.php";
    ?>