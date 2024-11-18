<?php
require_once '../core/database.php';

if (isset($_POST['username']) && isset($_POST['email'])) {
    $check_exists_Q = $db->query("SELECT username, email FROM `users` WHERE `id`='$userID'");
    $check_exists = mysqli_fetch_object($check_exists_Q);

    $isUsernameChanging = $_POST['username'] !== $check_exists->username;
    $isEmailChanging = $_POST['email'] !== $check_exists->email;

    if ($isUsernameChanging) {
        $newUsername = addslashes($_POST['username']);
        $dupCheckQ = $db->query("SELECT id FROM `users` WHERE `username`='$newUsername' AND `id` != '$userID'");

        if (mysqli_num_rows($dupCheckQ) > 0) {
            echo json_encode(["class_" => "d-block alert alert-danger", "msg" => "Username already taken by another user.", "status" => "error"]);
            exit;
        }
    }

    if ($isEmailChanging) {
        $newEmail = addslashes($_POST['email']);
        $dupCheckQ = $db->query("SELECT id FROM `users` WHERE `email`='$newEmail' AND `id` != '$userID'");

        if (mysqli_num_rows($dupCheckQ) > 0) {
            echo json_encode(["class_" => "d-block alert alert-danger", "msg" => "Email already taken by another user.", "status" => "error"]);
            exit;
        }
    }

    if (empty($_POST['password'])) {
        $_POST['password'] = $_POST['current_pwd'];
    } else {
        $_POST['password'] = md5($_POST['password']);
    }

    $updatePairs = [];
    foreach ($_POST as $key => $value) {
        if ($key != 'current_pwd') {
            $updatePairs[] = "$key = '" . addslashes($value) . "'";
        }
    }
    $updateQueryPart = implode(', ', $updatePairs);

    $upd_user_Q = $db->query("UPDATE `users` SET $updateQueryPart WHERE `id`='$userID'");
    if ($upd_user_Q) {
        echo json_encode(["class_" => "d-block alert alert-success", "msg" => "User Updated Successfully.", "status" => "success"]);
    } else {
        echo json_encode(["class_" => "d-block alert alert-danger", "msg" => "Something went wrong!", "status" => "error"]);
    }
}
