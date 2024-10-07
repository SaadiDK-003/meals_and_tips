<?php

require_once '../core/database.php';

if (isset($_POST['del_service'])) :
    $del_id = $_POST['del_service'];
    $del_c_Q = $db->query("DELETE FROM `services` WHERE `id`='$del_id'");
    if ($del_c_Q) :
        echo json_encode(["msg" => "Service has been deleted."]);
    else :
        echo json_encode(["msg" => "Something went wrong."]);
    endif;
endif;
