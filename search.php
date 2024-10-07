<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Search</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
    <style>
        /* General Form Styles */
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="clinic_page">

    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="hero">
            <div class="container">
                <div class="content hero-about-content">
                    <h1>Search</h1>
                    <!-- <h1>Welcome To Our My Doctor Clinic</h1> -->
                    <!-- <a href="#findClinicForm" class="btn btn-secondary btn-lg btn-block">Find A Clinic</a> -->
                </div>
            </div>
        </section>
        <!-- Search Form -->

        <section class="find-clinic">
            <div class="container my-5">
                <div class="row">
                    <h4 class="text-center">Find A Clinic</h4>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mx-auto">
                        <form id="findClinicForm">
                            <!-- Dropdown List -->
                            <select id="city" name="city" class="form-select mb-3">
                                <option value="all">Choose the Area</option>
                                <option value="Riyadh">Riyadh</option>
                                <option value="Baha">Baha</option>
                                <option value="Biesha">Biesha</option>
                                <option value="Makkah">Makkah</option>
                            </select>
                            <!-- Text Box -->

                            <select class="form-select mb-3" name="specialist" id="specialist" required>
                                <option value="" selected hidden>Select Specialist</option>
                                <?php $get_services_Q = $db->query("SELECT * FROM `services`");
                                while ($get_services = mysqli_fetch_object($get_services_Q)):
                                ?>
                                    <option value="<?= $get_services->service_name ?>"><?= $get_services->service_name ?></option>
                                <?php endwhile; ?>
                            </select>

                            <!-- <select id="search_clinic" name="search_clinic" class="form-select mb-3" disabled>
                                <option value="" selected hidden>Select Clinic</option>
                            </select> -->


                            <!-- Search Button -->
                            <button type="submit" id="search-clinic-btn" class="btn btn-secondary w-100" disabled>Search</button>
                        </form>
                    </div>
                </div>
                <!-- Render Clinic here -->
                <div id="render_list" class="row render_list">
                </div>
            </div>
        </section>

    </main>
    <footer></footer>


    <?php include './includes/js_links.php'; ?>
    <script>
        $(document).ready(function() {
            $('#city').on('change', function(e) {
                e.preventDefault();
                let city = $(this).val();

                // $.ajax({
                //     url: 'ajax/clinic_info.php',
                //     method: 'post',
                //     data: {
                //         city: city
                //     },
                //     beforeSend: function() {
                //         $("#search_clinic").children().remove();
                //     },
                //     success: function(res) {
                //         $("#search_clinic").append(res);
                //         if ($("#search_clinic").children('option').length > 0) {
                //             $("#search_clinic, #search-clinic-btn").removeAttr('disabled');
                //         } else {
                //             $("#search_clinic, #search-clinic-btn").attr('disabled', true);
                //         }
                //     }
                // });

                // $(document).on('click', '#search-clinic-btn', function(e) {
                //     e.preventDefault();
                //     let clinic_id = $("#search_clinic").val();
                //     console.log(clinic_id);

                //     $.ajax({
                //         url: 'ajax/clinic_info.php',
                //         method: 'post',
                //         data: {
                //             clinic_id: clinic_id
                //         },
                //         success: function(res) {
                //             $("#render_list").html(res);
                //         }
                //     });

                // });

                $(document).on('change', '#specialist', function(e) {
                    e.preventDefault();
                    $("#search-clinic-btn").removeAttr('disabled');
                });

                $(document).on('click', '#search-clinic-btn', function(e) {
                    e.preventDefault();
                    let specialist = $("#specialist").val();
                    let city = $("#city").val();

                    $.ajax({
                        url: 'ajax/clinic_info.php',
                        method: 'post',
                        data: {
                            specialist: specialist,
                            city: city
                        },
                        success: function(res) {
                            $("#render_list").html(res);
                        }
                    });
                })

            });

        });
    </script>
</body>

</html>