<?php
require_once 'core/database.php';
if (!isLoggedin()) {
    // header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="home">
    <?php include_once 'includes/header.php'; ?>


    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
</body>

</html>