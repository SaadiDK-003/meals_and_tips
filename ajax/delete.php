<?php
require_once '../core/database.php';

if (isset($_POST['del_id'])):
    $del_id = $_POST['del_id'];
    $table = $_POST['table'];
    echo delete($table, $del_id);
endif;


if (isset($_POST['fav_id']) && !isset($_POST['del_id'])):

    $fav_id = $_POST['fav_id'];
    $table_column = $_POST['table_column'];
    $usrID = $userID;

    $result = $db->query("SELECT `$table_column` FROM `users` WHERE `id` = '$usrID'");
    $cur_val = mysqli_fetch_object($result);
    $current_value = $cur_val->$table_column;

    $fav_array = $current_value ? explode(',', trim($current_value, ',')) : [];

    if (($key = array_search($fav_id, $fav_array)) !== false) {

        unset($fav_array[$key]);

        $new_value = implode(',', $fav_array);

        $upd_fav_Q = $db->query("UPDATE `users` SET `$table_column`='$new_value' WHERE `id`='$usrID'");
        if ($upd_fav_Q) {
            echo json_encode(["class_" => "text-bg-danger", "msg" => "Deleted Successfully.", "status" => "success"]);
        } else {
            echo json_encode(["class_" => "text-bg-danger", "msg" => "Something went wrong.", "status" => "error"]);
        }
    } else {
        echo json_encode(["class_" => "text-bg-danger", "msg" => "ID not found.", "status" => "error"]);
    }


endif;
