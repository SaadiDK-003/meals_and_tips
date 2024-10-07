<?php
require_once './core/database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Choose Your Doctor</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Header Section */
        header {
            background-color: #005772;
            color: white;
            padding: 20px;
            text-align: center;
        }

        /* Search Bar Section */
        .search-container {
            padding: 20px;
            text-align: center;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-container input[type="text"] {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Filters Section */
        .filters {
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
        }

        /* Doctor Profiles Section */
        .doctor-profiles {
            max-width: 1360px;
            margin-inline: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            padding: 20px;
        }

        .doctor-card {
            display: flex;
            align-items: center;
            background-color: white;
            flex-direction: column;
            margin: 15px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex-wrap: wrap;
        }

        .doctor-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .doctor-card h3 {
            margin: 10px 0;
            color: #005772;
        }

        .doctor-card p {
            color: #666;
        }

        .doctor-card button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .search-container input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }

            .filters {
                flex-direction: column;
                align-items: center;
            }

            .filters select {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body class="menu_page">
    <?php include_once './includes/header.php'; ?>
    <!-- Header Section -->
    <header>
        <h1>Choose Your Doctor</h1>
        <p>Find the right doctor for you</p>
    </header>

    <!-- Search Bar Section -->
    <!-- <div class="search-container">
        <input type="text" placeholder="Search by name, specialty, or location...">
        <button type="button">Search</button>
    </div> -->

    <!-- Filters Section -->
    <div class="filters">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">
                    <select class="form-select" name="specialist" id="specialist">
                        <?php $get_services_Q = $db->query("SELECT * FROM `services`");
                        while ($get_services = mysqli_fetch_object($get_services_Q)):
                        ?>
                            <option value="<?= $get_services->service_name ?>"><?= $get_services->service_name ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-12 col-md-4 d-none">
                    <select class="form-select" name="city" id="city">
                        <option value="" selected hidden>All Locations</option>
                        <option value="Riyadh">Riyadh</option>
                        <option value="Baha">Baha</option>
                        <option value="Bisha">Bisha</option>
                        <option value="Makkah">Makkah</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <select class="form-select" name="rating" id="rating">
                        <option value="" selected hidden>Select Rating</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Profiles Section -->
    <div class="doctor-profiles" id="doctor-profiles">
        <!-- Doctor Card -->
        <?php
        $spe_q = $db->query("CALL `get_all_doctors`()");
        while ($spe_list = mysqli_fetch_object($spe_q)):
        ?>

            <div class="doctor-card">
                <img src="<?= $spe_list->profile_pic ?? './img/doc.jpg'; ?>" alt="Doctor Photo">
                <h3><?= $spe_list->name ?></h3>
                <p><?= $spe_list->certificate ?> | <?= $spe_list->city ?></p>

                <a class="btn btn-primary" target="_blank" href="callus.php?doc_id=<?= $spe_list->u_id ?>">View Profile</a>
            </div>

        <?php endwhile;
        $spe_q->close();
        $db->next_result();
        ?>

    </div>

    <?php include 'includes/js_links.php'; ?>

    <script>
        $(document).ready(function() {
            $("#specialist").on('change', function(e) {
                e.preventDefault();
                let specialist = $(this).val();
                let rating = $("#rating").val();
                $.ajax({
                    url: 'ajax/doc_filter.php',
                    method: 'post',
                    data: {
                        specialist: specialist,
                        rating: rating
                    },
                    success: function(res) {
                        $("#doctor-profiles").html(res);
                    }
                })
            });

            $("#rating").on('change', function(e) {
                e.preventDefault();
                let rating = $(this).val();
                let specialist = $("#specialist").val();
                $.ajax({
                    url: 'ajax/doc_filter.php',
                    method: 'post',
                    data: {
                        specialist: specialist,
                        rating: rating
                    },
                    success: function(res) {
                        $("#doctor-profiles").html(res);
                    }
                })
            });
        });
    </script>

</body>

</html>