<?php
    require_once "dbConnection.php";
    $sql = "SELECT * FROM articles";
    $op = mysqli_query($connect, $sql);
?>
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
        <table class="table container mt-3">
            <thead>
                <tr>
                    <th scope="col">Tile</th>
                    <th scope="col">Content</th>
                    <th scope="col">Image</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($op)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['title'];?>
                    </td>
                    <td>
                        <?php echo $row['content'];?>
                    </td>
                    <td>
                        <img style='width: 50px; height: 50px;' src='<?php echo $row["image"] ?>'>
                    </td>
                    <td>
                        <a href="remove.php?id=<?php echo $row["id"] ?>" class='btn btn-danger'>Delete</a>
                    </td>
                </tr>
                <?php
                    }
                    mysqli_close($connect);
                ?>
            </tbody>
        </table>
    </body>
</html>