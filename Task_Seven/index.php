<?php
    require_once "dbConnection.php";
    function clean($input) {
        $result = trim($input);
        $result = strip_tags($result);
        $result = stripslashes($result);
        return $result;
    };
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = clean($_POST["title"]);
        $content = $_POST["content"];
        $image = $_FILES["image"];
        $errors = [];
        if (!$title) {
            $errors["title"] = "Title is Required";
        } elseif (!$title) {
            $errors["title"] = "Title must be String";
        }
        if (!$content) {
            $errors["content"] = "Content is Required";
        } elseif (strlen($content) > 50) {
            $errors["content"] = "Content Length Must be less than 50 Character";
        }
        if (!$image["name"]) {
            $errors["image"] = "File is Required";
        } else {
            $imageName = $image["name"];
            $imageTempName = $image["tmp_name"];
            $imageType = $image["type"];
            $allowExtensions = ["png", "jpeg", "jpg"];
            $imageArray = explode("/", $imageType);
            $imageExtensions = end($imageArray);
            if (in_array($imageExtensions, $allowExtensions) && count($errors) == 0 ) {
                $imageFinalName = time().rand().".".$imageExtensions;
                $distPath = "uploads/".$imageFinalName;
                if (!move_uploaded_file($imageTempName, $distPath)) {
                    $errors["image"] = "Error Try Again";
                }
            } else {
                $errors["image"] = "Invalid Extension";
            }
        }
        if (count($errors) > 0 ) {
            foreach ($errors as $key => $value) {
                echo '* '.$key.' : '.$value.'<br>';
            }
        } else {
            $sql = "INSERT INTO articles (title, content, image) VALUES ('$title', '$content', '$distPath')";
            $op = mysqli_query($connect, $sql);
            mysqli_close($connect);
            if ($op) {
                $message = "Row Inserted";
                $_SESSION["message"] = $message;
                header("location: articles.php");
            } else {
                echo "Error: Try Again".mysqli_error($connect);
            }
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
        <title>Article</title>
    </head>
    <body>
        <form class="row g-3 container mx-auto" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="inputTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="inputTitle" name="title">
            </div>
            <div class="col-md-6">
                <label for="inputContent" class="form-label">Content</label>
                <input type="text" class="form-control" id="inputContent" name="content">
            </div>
            <div class="col-md-12">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" id="formFile" name="image">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </body>
</html>