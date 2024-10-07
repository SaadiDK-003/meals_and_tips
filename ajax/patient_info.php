<?php
require_once '../core/database.php';

if (isset($_POST['patient_ID_modal'])) :
    $patientID = $_POST['patient_ID_modal'];

    $r_Q = $db->query("CALL `get_visitor_info`($patientID)");
    $response = array();
    $v_data = mysqli_fetch_object($r_Q);

    $response = ["visitorName" => $v_data->name, "visitorEmail" => $v_data->email, "visitorPhone" => $v_data->phone];
    echo json_encode($response);
    $r_Q->close();
    $db->next_result();
endif;
