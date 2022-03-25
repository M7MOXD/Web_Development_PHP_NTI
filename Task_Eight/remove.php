<?php
require_once "./class/articleClass.php";
$id = $_GET["id"];
$article = new Article();
$result = $article->delete($id);
?>