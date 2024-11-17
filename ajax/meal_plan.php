<?php
require_once '../core/database.php';

if (isset($_POST['meal_id'])):

    $meal_id = $_POST['meal_id'];
    $usrID = $userID;

    $result = $db->query("SELECT `fav_meals` FROM `users` WHERE `id` = '$usrID'");

    $cur_val = mysqli_fetch_object($result);
    $cur_value = $cur_val->fav_meals;

    $fav_array = $cur_value ? explode(',', trim($cur_value, ',')) : [];


    if (!in_array($meal_id, $fav_array)) {

        $fav_array[] = $meal_id;
        $new_value = implode(',', $fav_array);

        $upd_fav_Q = $db->query("UPDATE `users` SET `fav_meals`='$new_value' WHERE `id`='$usrID'");
        if ($upd_fav_Q) {
            echo json_encode(["class_" => "text-bg-success", "msg" => "Added Successfully.", "status" => "success"]);
        }
    } else {
        echo json_encode(["class_" => "text-bg-danger", "msg" => "Already Added In Your Favorite List.", "status" => "error"]);
    }
endif;
