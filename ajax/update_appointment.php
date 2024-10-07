<?php

require_once '../core/database.php';

if (isset($_POST['update_res_id'])) :
    $update_res_id = $_POST['update_res_id'];
    $r_status = $_POST['r_status'];
    $msg = '';
    if ($r_status == 'cancel') :
        $cancel_Q = $db->query("DELETE FROM `reservation` WHERE `id`='$update_res_id'");
        if ($cancel_Q) :
            $msg = '<h6 class="alert alert-danger text-center">Appointment Deleted.</h6>';
        endif;
    else :
        $upd_r_Q = $db->query("UPDATE `reservation` SET `status`='$r_status' WHERE `id`='$update_res_id'");
        if ($upd_r_Q) :
            $msg = '<h6 class="alert alert-success text-center">Status Updated.</h6>';
        endif;
    endif;
    echo $msg;
endif;
