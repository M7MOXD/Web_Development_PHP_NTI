<?php
    $file = fopen("txt.txt", "r+");
    $articlesArr = [];
    while (!feof($file)) {
        array_push($articlesArr, fgets($file));
    }
    fclose($file);
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $articleRow = $_POST["articleRow"];
        $file = fopen("txt.txt", "w+");
        array_splice($articlesArr, $articleRow, 1);
        for ($i=0; $i < count($articlesArr); $i++) {
            fwrite($file, $articlesArr[$i]);
        }
        fclose($file);
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
                    for ($i=0; $i < count($articlesArr); $i++) { 
                        echo "<tr>";
                        if ($i == count($articlesArr) - 1) {
                            continue;
                        }
                        $singleArticle = explode("|", $articlesArr[$i]);
                        for ($j=0; $j < count($singleArticle); $j++) {
                            if ($j == 2) {
                                echo "<td><img style='width: 50px; height: 50px;' src=".$singleArticle[$j]."></td>";
                            } else {
                                echo "<td>";
                                echo $singleArticle[$j];
                                echo "</td>";
                            }
                        }
                        echo "<td>";
                        echo "<form action=".$_SERVER["PHP_SELF"]." method='POST'>";
                        echo "<input type='hidden' id='articleRow' name='articleRow' value=".$i.">";
                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>