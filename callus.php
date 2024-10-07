<?php
require_once './core/database.php';
$doc_id = 0;
if (isset($_GET['doc_id'])):
    $doc_id = $_GET['doc_id'];
endif;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Call Us - Doctor Profile <?= $doc_id ?></title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Container Styles */
        .container-page {
            margin-block: 30px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Doctor Profile Section */
        .profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile img {
            width: 150px;
            height: 150px;
            /* border-radius: 50%; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            flex: 1;
            position: relative;
        }

        .profile-info h2 {
            margin: 0;
            font-size: 28px;
            color: #005772;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        .buttons-wrapper {
            display: grid;
            gap: 10px;
            position: absolute;
            top: 0;
            right: 10px;
        }

        .buttons-wrapper a {
            position: relative;
        }

        .buttons-wrapper a i {
            left: -30px;
            font-size: 20px;
        }

        .buttons-wrapper a:first-child i {
            color: #198754;
        }

        .buttons-wrapper a:last-child i {
            color: #0d6efd;
        }

        /* .buttons-wrapper a:first-child::before {
            content: 'Clinic: ';
            position: absolute;
            left: -55px;
            color: #000;
            font-weight: bold;
        } */

        /* Contact Info Section */
        .contact-info {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .contact-info h3 {
            margin: 0;
            font-size: 20px;
            color: #005772;
        }

        .contact-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        /* Availability Section */
        .availability {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .availability-card {
            flex: 1;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            text-align: center;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .availability-card:last-child {
            margin-right: 0;
        }

        .availability-card h4 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .availability-card p {
            margin: 10px 0;
            font-size: 16px;
            color: #666;
        }

        .availability-card button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .availability-card button:hover {
            background-color: #45a049;
        }

        /* Unavailability Section */
        .unavailability {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .unavailability-card {
            flex: 1;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            text-align: center;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .unavailability-card:last-child {
            margin-right: 0;
        }

        .unavailability-card h4 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .unavailability-card p {
            margin: 10px 0;
            font-size: 16px;
            color: #666;
        }

        .unavailability-card button {
            padding: 10px 20px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .unavailability-card button:hover {
            background-color: #ff0000;
        }
    </style>
</head>

<body class="menu_page">
    <?php include_once './includes/header.php'; ?>

    <div class="container container-page">
        <?php
        $doc_info_Q = $db->query("CALL `get_doc_info`($doc_id)");
        if (mysqli_num_rows($doc_info_Q) > 0):
            $docInfo = mysqli_fetch_object($doc_info_Q);
        ?>
            <!-- Doctor Profile Section -->
            <div class="profile">
                <img src="<?= $docInfo->profile_pic ?? './img/doc.jpg' ?>" alt="Doctor Photo">
                <div class="profile-info">
                    <h2><?= $docInfo->name ?></h2>
                    <p><?= $docInfo->certificate ?></p>
                    <p><?= $docInfo->experience ?></p>
                    <p><?= $docInfo->city ?></p>
                    <div class="buttons-wrapper">
                        <a href="tel:<?= $docInfo->clinic_number ?>" class="btn btn-success">
                            <i class="fas fa-phone d-inline-block me-2 position-absolute"></i>
                            <?= $docInfo->clinic_number ?></a>
                        <a href="./appointment.php" class="btn btn-primary"><i class="far fa-calendar d-inline-block me-2 position-absolute"></i>Appointment Form</a>
                    </div>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="contact-info">
                <h3>Contact Information</h3>
                <p><i class="fas fa-envelope"></i> <?= $docInfo->email ?></p>
                <p><i class="fas fa-phone"></i> <?= $docInfo->phone ?></p>
                <p><i class="fas fa-location-dot"></i> <?= $docInfo->clinic_location ?></p>
            </div>

            <!-- Availability Section -->
            <div class="availability">
                <div class="availability-card">
                    <h4>Weekdays</h4>
                    <p><?= date('h:m A', strtotime($docInfo->checkin_time)) ?> - <?= date('h:m A', strtotime($docInfo->checkout_time)) ?></p>
                    <button>Available</button>
                </div>
                <div class="<?= ($docInfo->weekend_available != 'no') ? 'availability-card' : 'unavailability-card' ?>">
                    <?php if ($docInfo->weekend_available != 'no'): ?>
                        <h4>Weekends</h4>
                        <p class="d-none"><?= date('h:m A', strtotime($docInfo->checkin_time)) ?> - <?= date('h:m A', strtotime($docInfo->checkout_time)) ?></p>
                        <button>Available</button>
                    <?php else: ?>
                        <button>Unavailable</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <h3 class="text-center mb-0">No Info Available.</h3>
        <?php endif; ?>

    </div>

    <?php include './includes/js_links.php'; ?>

    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>