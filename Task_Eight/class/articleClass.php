<?php
session_start();
require_once "dbClass.php";
require_once "validatorClass.php";
class Article
{
    private $title;
    private $content;
    private $image;
    public function create($input, $file)
    {
        $errors = [];
        $validator = new Validator();
        $this->title = $validator->clean($input['title']);
        $this->content = $validator->clean($input['content']);
        if (!$validator->validation($this->title, 'required')) {
            $errors['title'] = "Field Required";
        } elseif (!$validator->validation($this->title, 'string')) {
            $errors['title'] = "Invalid Title";
        }
        if (!$validator->validation($this->content, 'required')) {
            $errors['content'] = "Field Required";
        } elseif (!$validator->validation($this->content, 'string')) {
            $errors['content'] = "Invalid Content";
        }
        if (!$validator->validation($file['image']['name'], "required")) {
            $errors['image'] = "File Required";
        } elseif (!$validator->validation($file["image"], "image")) {
            $errors['image'] = "Invalid Image Format";
        }
        if (count($errors) > 0) {
            $message = $errors;
        } else {
            $this->image = $validator->upload($_FILES['image']);
            $db = new DB();
            $sql = "INSERT INTO articles (title, content, image) VALUES ('$this->title', '$this->content', '$this->image')";
            $op = $db->runQuery($sql);
            if ($op) {
                $message = ["op" => "Row Inserted"];
            } else {
                $message = ["op" => "Error Try Again"];
            }
            $_SESSION["message"] = $message;
            header("location: articles.php");
        }
    }
    public function update($id, $input, $file)
    {
        $errors = [];
        $db = new DB();
        $sql = "SELECT * FROM articles WHERE id = $id";
        $op  = $db->runQuery($sql);
        $data = mysqli_fetch_assoc($op);
        $validator = new Validator();
        $this->title = $validator->clean($input['title']);
        $this->content = $validator->clean($input['content']);
        if (!$validator->validation($this->title, 'required')) {
            $errors['title'] = "Field Required";
        } elseif (!$validator->validation($this->title, 'string')) {
            $errors['title'] = "Invalid Title";
        }
        if (!$validator->validation($this->content, 'required')) {
            $errors['content'] = "Field Required";
        } elseif (!$validator->validation($this->content, 'string')) {
            $errors['content'] = "Invalid Content";
        }
        if ($validator->validation($file['image']['name'], "required")) {
            if (!$validator->validation($file["image"], "image")) {
                $errors['image'] = "Invalid Image Format";
            }
        }
        if (count($errors) > 0) {
            $message = $errors;
        } else {
            if ($validator->validation($_FILES['image']['name'], "required")) {
                $this->image = $validator->upload($_FILES['image']);
                unlink('uploads/' . $data['image']);
            } else {
                $this->image = $data['image'];
            }
            $sql = "UPDATE articles SET title = '$this->title', content = '$this->content', image = '$this->image' WHERE id = $id";
            $op = $db->runQuery($sql);
            if ($op) {
                $message = ["op" => "Row Updated"];
            } else {
                $message = ["op" => "Error Try Again"];
            }
            $_SESSION["message"] = $message;
            header("location: articles.php");
        }
    }
    public function delete($id)
    {
        $db = new DB();
        $sql = "SELECT * FROM articles WHERE id = $id";
        $op  = $db->runQuery($sql);
        $data = mysqli_fetch_assoc($op);
        $sql = "DELETE FROM articles WHERE id = $id";
        $op = $db->runQuery($sql);
        if ($op) {
            unlink("uploads/" . $data['image']);
            $message = ["op" => "Raw Removed"];
        } else {
            $message = ["op" => "Error Try Again"];
        }
        $_SESSION["message"] = $message;
        header("location: articles.php");
    }
}
?>