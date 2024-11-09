<?php
require_once '../core/database.php';

if (isset($_POST['recipe_id'])):
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
