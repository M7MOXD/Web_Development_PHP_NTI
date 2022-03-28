<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Blog Articles</title>
</head>

<body>
    <?php
    if (isset($_SESSION["message"])) {
        echo "*" . $_SESSION["message"];
        unset($_SESSION["message"]);
    }
    ?>
    <table class="table container mt-3">
        <thead>
            <tr>
                <th scope="col">Tile</th>
                <th scope="col">Content</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php
                    if (isset($_SESSION['blog'])) {
                        echo $_SESSION['blog']['title'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($_SESSION['blog'])) {
                        echo $_SESSION['blog']['content'];
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($_SESSION['blog'])) {
                    ?>
                    <img style='width: 50px; height: 50px;' src='<?php echo url('uploads')."/".$_SESSION['blog']['imgName']; ?>'>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
