<?php
require_once '../core/database.php';

if (isset($_POST['category_name'])):
    $cat_name = $_POST['category_name'];
    $checKCat_Q = $db->query("SELECT * FROM `categories` WHERE `category_name`='$cat_name'");
    if (mysqli_num_rows($checKCat_Q) > 0):
        echo json_encode(["status" => "d-block alert alert-danger", "msg" => "Category already exist."]);
    else:
        $cat_Q = $db->query("INSERT INTO `categories` (category_name) VALUES('$cat_name')");
        if ($cat_Q):
            echo json_encode(["status" => "d-block alert alert-success", "msg" => "Category added successfully."]);
        endif;
    endif;
endif;
