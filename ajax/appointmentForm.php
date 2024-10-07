<?php

require_once '../core/database.php';

if (isset($_POST['start_time']) && !isset($_POST['edit_res_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $s_time = $_POST['start_time'];
    $e_time = $_POST['end_time'];
    $clinic_id = $_POST['clinic_id'];
    $res_Q = $db->query("INSERT INTO `reservation` (start_time,end_time,clinic_id,doctor_id,patient_id) VALUES('$s_time','$e_time','$clinic_id','$doctor_id','$userID')");

    if ($res_Q) {
        echo json_encode(["status" => "success", "msg" => "Appointment request has been submitted."]);
    } else {
        echo json_encode(["status" => "danger", "msg" => "Something went wrong."]);
    }
}


if (isset($_POST['edit_res_id'])) :

    $cafeID = $_POST['cafe'];
    $s_time = $_POST['start_time'];
    $e_time = $_POST['end_time'];
    $t_members = $_POST['total_members'];
    $t_tables = $_POST['total_tables'];
    $t_location = $_POST['table_location'];
    $events = $_POST['events'];
    $edit_res_id = $_POST['edit_res_id'];

    $edit_res_Q = $db->query("UPDATE `reservation` SET `cafe_id`='$cafeID', `start_time`='$s_time', `end_time`='$e_time', `total_members`='$t_members', `total_tables`='$t_tables', `table_location`='$t_location', `events`='$events' WHERE `id`='$edit_res_id'");
    if ($edit_res_Q) :
        echo json_encode(["status" => "success", "msg" => "Reservation has been updated."]);
    else :
        echo json_encode(["status" => "danger", "msg" => "Something went wrong."]);
    endif;
endif;


if (isset($_POST['del_res'])) :
    $del_ = $_POST['del_res'];
    $del_r_Q = $db->query("DELETE FROM `reservation` WHERE `id`='$del_'");
    if ($del_r_Q) {
        echo json_encode(["msg" => "Appointment has been deleted."]);
    }
endif;
