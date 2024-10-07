<?php
require_once '../core/database.php';

if (isset($_POST['del_id'])) :

    $del_id = $_POST['del_id'];

    $del_Q = $db->query("DELETE FROM `users` WHERE `id`='$del_id'");
    if ($del_Q) {
        echo json_encode(["msg" => "User has been deleted."]);
    }

endif;
