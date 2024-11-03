<?php
require_once '../core/database.php';

if (isset($_POST['recipe_title']) && isset($_POST['ingredients'])):
    $recipe_title = $_POST['recipe_title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $nutritionist_id = $_POST['nutritionist_id'];

    $recipe_Q = $db->query("INSERT INTO `recipes` (recipe_title,ingredients,instructions,nutritionist_id) VALUES('$recipe_title','$ingredients','$instructions','$nutritionist_id')");
    if ($recipe_Q):
        echo json_encode(["status" => "d-block alert alert-success", "msg" => "Recipe added successfully."]);
    endif;
endif;
