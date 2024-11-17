<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <?php include_once 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="meals_and_plan">
    <?php include_once 'includes/header.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="text-center">Meals & Plan</h2>
            </div>
            <?php $get_mp_Q = $db->query("CALL `get_meal_plans`()");
            while ($mp_list = mysqli_fetch_object($get_mp_Q)):
            ?>
                <div class="col-12 mb-3">
                    <div class="content bg-white rounded p-3 position-relative">
                        <h3 class="mb-0 text-secondary"><?= $mp_list->meal_desc ?> | <span class="btn btn-secondary"><?= $mp_list->category_name ?></span></h3>
                        <a href="#!" class="position-absolute btn btn-sm btn-success toggle_btn"><i class="fas fa-plus"></i></a>
                        <div class="time_plan_wrapper d-grid gap-2 text-center">
                            <div class="time_plan alert alert-secondary mb-0 p-1">
                                <p class="mb-0"><strong>Breakfast Time:</strong></p>
                                <p class="mb-0"><?= date('h:i A', strtotime($mp_list->breakfast_time)); ?></p>
                                <p class="mb-0"><?= $mp_list->breakfast_meal ?></p>
                            </div>
                            <div class="time_plan alert alert-secondary mb-0 p-1">
                                <p class="mb-0"><strong>Snack Time:</strong></p>
                                <p class="mb-0"><?= date('h:i A', strtotime($mp_list->snack_time)); ?></p>
                                <p class="mb-0"><?= $mp_list->snack_meal ?></p>
                            </div>
                            <div class="time_plan alert alert-secondary mb-0 p-1">
                                <p class="mb-0"><strong>Lunch Time:</strong></p>
                                <p class="mb-0"><?= date('h:i A', strtotime($mp_list->lunch_time)); ?></p>
                                <p class="mb-0"><?= $mp_list->lunch_meal ?></p>
                            </div>
                            <div class="time_plan alert alert-secondary mb-0 p-1">
                                <p class="mb-0"><strong>Dinner Time:</strong></p>
                                <p class="mb-0"><?= date('h:i A', strtotime($mp_list->dinner_time)); ?></p>
                                <p class="mb-0"><?= $mp_list->dinner_meal ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            $get_mp_Q->close();
            $db->next_result(); ?>
        </div>
    </div>


    <?php include_once 'includes/footer.php'; ?>
    <?php include_once 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            $(".toggle_btn").on('click', function(e) {
                e.preventDefault();
                if ($(this).children('i').hasClass('fa-minus')) {
                    $(this).children('i').removeClass('fa-minus').addClass('fa-plus');
                } else {
                    $(this).children('i').removeClass('fa-plus').addClass('fa-minus');
                }
                $(this).next().toggleClass('active');
            });
        });
    </script>
</body>

</html>