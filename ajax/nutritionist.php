<?php
require_once '../core/database.php';

if (!isset($_POST['edu_title']) && isset($_POST['recipe_title']) && isset($_POST['ingredients'])):

    $targetDir = '../img/recipe/';

    $recipe_title = $_POST['recipe_title'];
    $ingredients = $_POST['ingredients'];
    $instructions = mysqli_real_escape_string($db, $_POST['instructions']);
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


if (!isset($_POST['recipe_title']) && isset($_POST['edu_title']) && isset($_POST['edu_description'])):

    $targetDir = '../img/edu/';
    $targetDirPDF = '../pdf/';

    $edu_title = $_POST['edu_title'];
    $edu_link = $_POST['edu_link'];
    $edu_description = mysqli_real_escape_string($db, $_POST['edu_description']);

    $nutritionist_id = $_POST['edu_nutritionist_id'];

    $msg = '';

    if (!empty($_FILES["edu_image"]["name"]) && !empty($_FILES["edu_pdf"]["name"])) {

        // For Image
        $fileName = basename($_FILES["edu_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        // For PDF
        $fileNamePDF = basename($_FILES["edu_pdf"]["name"]);
        $targetFilePathPDF = $targetDirPDF . $fileNamePDF;
        $fileTypePDF = pathinfo($targetFilePathPDF, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        $allowTypesPDF = array('pdf', 'PDF');

        // For Image
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["edu_image"]["tmp_name"], $targetFilePath)) {

                // For PDF
                if (in_array($fileTypePDF, $allowTypesPDF)) {
                    if (move_uploaded_file($_FILES["edu_pdf"]["tmp_name"], $targetFilePathPDF)) {
                        $recipe_Q = $db->query("INSERT INTO `edu_content` (edu_title,edu_image,edu_pdf,edu_link,edu_desc,nutritionist_id) VALUES('$edu_title','$fileName','$fileNamePDF','$edu_link','$edu_description','$nutritionist_id')");
                        if ($recipe_Q):
                            $msg = json_encode(["class_" => "d-block alert alert-success", "msg" => "Content added successfully.", "status" => "success"]);
                        endif;
                    } else {
                        $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, there was an error uploading your file.", "status" => "error"]);
                    }
                } else {
                    $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, only PDF file is allowed to upload.", "status" => "error"]);
                }
            } else {
                $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, there was an error uploading your file.", "status" => "error"]);
            }
        } else {
            $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.", "status" => "error"]);
        }
    }
    echo $msg;

endif;
