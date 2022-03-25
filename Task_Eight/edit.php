<?php
require_once "./class/dbClass.php";
require_once "./class/articleClass.php";
$id = $_GET["id"];
$db = new DB();
$sql = "SELECT * FROM articles WHERE id=$id";
$op = $db->runQuery($sql);
if ($op) {
    $data = mysqli_fetch_assoc($op);
} else {
    echo "Error: Try Again" . mysqli_error($connect);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $article = new Article();
    $article->update($id, $_POST, $_FILES);
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
    <form class="row g-3 container mx-auto" action="edit.php?id=<?php echo $data["id"]; ?>" method="POST" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="inputTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="inputTitle" name="title" value="<?php echo $data["title"] ?>">
        </div>
        <div class="col-md-6">
            <label for="inputContent" class="form-label">Content</label>
            <input type="text" class="form-control" id="inputContent" name="content" value="<?php echo $data["content"] ?>">
        </div>
        <div class="col-md-12">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="image">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</body>

</html>