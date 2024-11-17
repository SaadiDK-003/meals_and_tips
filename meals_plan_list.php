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

<body id="meals_plan">
    <?php include_once 'includes/header.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="text-center">Meals Plan</h2>
            </div>
            <?php $get_mp_Q = $db->query("CALL `get_meal_plans`()");
            while ($mp_list = mysqli_fetch_object($get_mp_Q)): ?>
                <div class="col-12 mb-3">
                    <div class="content_meal bg-white rounded p-3 position-relative">
                        <h3 class="mb-0 text-secondary"><?= $mp_list->meal_desc ?> | <span class="btn btn-secondary"><?= $mp_list->category_name ?></span></h3>
                        <a href="#!" data-id="<?= $mp_list->mp_id ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Favorite" data-bs-offset="-40,5" data-bs-trigger="hover" class="position-absolute btn btn-sm btn-danger add_fav_meal"><i class="fas fa-star"></i></a>
                        <a href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="Expand or Collapse" data-bs-offset="45,5" data-bs-trigger="hover" class="position-absolute btn btn-sm btn-success toggle_btn"><i class="fas fa-plus"></i></a>
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

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
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

            $(document).on("click", ".add_fav_meal", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $(this).css({
                    "background-color": "#777",
                    "border-color": "#777",
                    "pointer-events": "none"
                });
                $.ajax({
                    url: 'ajax/meal_plan.php',
                    method: 'post',
                    data: {
                        meal_id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if ($(".toast").hasClass('text-bg-danger')) {
                            $(".toast").removeClass('text-bg-danger');
                        }
                        $(".toast").addClass(res.class_);
                        $(".toast-body").html(res.msg);
                        toast.show();
                        setTimeout(() => {
                            $(".add_fav_meal").removeAttr('style');
                        }, 1200);
                    }
                })
            });
        });
    </script>
</body>

</html>