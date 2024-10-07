<?php
session_start();
$config_path = $_SERVER['DOCUMENT_ROOT'] . '/clinic/';
require_once '' . $config_path . 'config.php';
$db = mysqli_connect(HOST, DB_USER, DB_PWD, DB_NAME);
include_once 'functions.php';
$userID = '';
$userName = '';
$userEmail = '';
$userPhone = '';
$userRole = '';
$clinic__ID = '';
$profile_PIC = '';
if (isset($_SESSION['user'])) {
    $userID = $_SESSION['user'];
    $getUserQ = $db->query("SELECT * FROM `users` WHERE `id`='$userID'");
    $userData = mysqli_fetch_object($getUserQ);
    $userName = $userData->name;
    $userEmail = $userData->email;
    $userPhone = $userData->phone;
    $userRole = $userData->role;
    $clinic_ID = $userData->clinic_id;
    $profile_PIC = $userData->profile_pic;

    if ($userRole == 'doctor') {
        $getCafeQ = $db->query("SELECT * FROM `clinic` WHERE `id`='$clinic_ID'");
        if (mysqli_num_rows($getCafeQ) > 0) {
            $getClinicData = mysqli_fetch_object($getCafeQ);
            $clinic__ID = $getClinicData->id;
        }
    }
}
