<?php
require_once '../core/database.php';

if (isset($_POST['recipe_id']) && !isset($_POST['fav_id'])):
    $recipe_id = $_POST['recipe_id'];
    $recipe_Q = $db->query("CALL `get_recipes_list_approved_by_recipe_id`($recipe_id)");
    $recipe_ = mysqli_fetch_object($recipe_Q);
    $ingredients_final = '';
    $ingredients = explode(',', $recipe_->ingredients);
    $key = count($ingredients);
    foreach ($ingredients as $value) {
        $ingredients_final .= '<li>' . $value . '</li>';
    }
    echo json_encode(["ingredients_list" => $ingredients_final, "list_count" => $key, "title" => $recipe_->recipe_title, "instructions" => $recipe_->instructions, "img" => $recipe_->recipe_img, "nutritionist" => $recipe_->username, "category_name" => $recipe_->category_name]);
endif;


if (isset($_POST['fav_id']) && !isset($_POST['recipe_id'])):

    $fav_id = $_POST['fav_id'];
    $usrID = $_POST['usrID'];

    $result = $db->query("SELECT `fav_recipes` FROM `users` WHERE `id` = '$usrID'");

    $cur_val = mysqli_fetch_object($result);
    $cur_value = $cur_val->fav_recipes;

    $fav_array = $cur_value ? explode(',', trim($cur_value, ',')) : [];


    if (!in_array($fav_id, $fav_array)) {

        $fav_array[] = $fav_id;
        $new_value = implode(',', $fav_array);

        $upd_fav_Q = $db->query("UPDATE `users` SET `fav_recipes`='$new_value' WHERE `id`='$usrID'");
        if ($upd_fav_Q) {
            echo json_encode(["class_" => "text-bg-success", "msg" => "Added Successfully.", "status" => "success"]);
        }
    } else {
        echo json_encode(["class_" => "text-bg-danger", "msg" => "Already Added In Your Favorite List.", "status" => "error"]);
    }

endif;
