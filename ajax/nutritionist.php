<?php
require_once '../core/database.php';

$targetDir = '../img/recipe/';

if (isset($_POST['recipe_title']) && isset($_POST['ingredients'])):
    $recipe_title = $_POST['recipe_title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $nutritionist_id = $_POST['nutritionist_id'];
    $category_id = $_POST['category_type'];
    $msg = '';

    if (!empty($_FILES["recipe_img"]["name"])) {

        $fileName = basename($_FILES["recipe_img"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($_FILES["recipe_img"]["tmp_name"], $targetFilePath)) {
                $recipe_Q = $db->query("INSERT INTO `recipes` (recipe_title,ingredients,instructions,nutritionist_id,cat_id,recipe_img) VALUES('$recipe_title','$ingredients','$instructions','$nutritionist_id','$category_id','$fileName')");
                if ($recipe_Q):
                    $msg = json_encode(["class_" => "d-block alert alert-success", "msg" => "Recipe added successfully.", "status" => "success"]);
                endif;
            } else {
                $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, there was an error uploading your file.", "status" => "error"]);
            }
        } else {
            $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.", "status" => "error"]);
        }
    }
    echo $msg;
endif;
