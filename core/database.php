<?php
session_start();
$config_path = $_SERVER['DOCUMENT_ROOT'] . '/meals_and_tips/';
require_once '' . $config_path . 'config.php';
$db = mysqli_connect(HOST, DB_USER, DB_PWD, DB_NAME);
include_once 'functions.php';
$userID = '';
$userName = '';
$userEmail = '';
$userPhone = '';
$userRole = '';
$fav_recipes = '';
if (isset($_SESSION['user'])) {
    $userID = $_SESSION['user'];
    $getUserQ = $db->query("SELECT * FROM `users` WHERE `id`='$userID'");
    $userData = mysqli_fetch_object($getUserQ);
    $userName = $userData->username;
    $userEmail = $userData->email;
    $userPhone = $userData->phone;
    $userRole = $userData->role;
    $fav_recipes = $userData->fav_recipes;
}
