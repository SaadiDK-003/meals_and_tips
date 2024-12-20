<?php
require_once 'core/database.php';
if (!isLoggedin() || $userRole == 'nutritionist') {
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | User Dashboard</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="userDashboard">
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto my-5 min-h-800 list-wrapper">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-end">
                <a href="./profile.php" class="btn btn-primary">My Profile</a>
            </div>
        </div>
        <!-- Favorite Recipes -->
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="text-center">Favorite Recipes</h2>
            </div>
            <?php
            $list_recipes_Q = $db->query("CALL `get_recipes_list_fav`('$fav_recipes')");
            if (mysqli_num_rows($list_recipes_Q) > 0):
                while ($list_recipes = mysqli_fetch_object($list_recipes_Q)):
            ?>
                    <div class="col-12 col-md-3 mb-4">
                        <div class="content">
                            <div class="img">
                                <img src="img/recipe/<?= $list_recipes->recipe_img ?>" alt="recipe_img_<?= $list_recipes->recipe_id ?>">
                            </div>
                            <h3 class="mb-0 text-center"><?= $list_recipes->recipe_title ?></h3>
                            <p class="mb-0 text-center"><?= $list_recipes->instructions ?></p>
                            <div class="buttons_wrapper d-flex w-100 justify-content-center gap-2">
                                <a href="#!" data-id="<?= $list_recipes->recipe_id ?>" data-bs-toggle="modal" data-bs-target="#RecipeDetails" class="btn-recipe-details btn btn-primary w-75">Details</a>
                                <a href="#!" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete From Favorite" data-bs-trigger="hover" data-id="<?= $list_recipes->recipe_id ?>" data-usr="<?= $userID ?>" class="btn-recipe-fav btn btn-danger w-25">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <h3 class="alert alert-secondary text-center">No Recipe Available Right Now.</h3>
            <?php endif;
            $list_recipes_Q->close();
            $db->next_result(); ?>
        </div>
        <hr>
        <!-- Favorite Meal Plans -->
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="text-center">Favorite Meal Plans</h2>
            </div>
            <?php
            $list_meals_Q = $db->query("CALL `get_meal_plans_by_ids`('$fav_meals')");
            if (mysqli_num_rows($list_meals_Q) > 0):
                while ($list_meals = mysqli_fetch_object($list_meals_Q)):
            ?>
                    <div class="col-12 mb-3">
                        <div class="content_meal bg-white rounded p-3 position-relative">
                            <h3 class="mb-0 text-secondary"><?= $list_meals->plan_title ?> | <span class="btn btn-secondary"><?= $list_meals->category_name ?></span></h3>
                            <a href="#!" data-id="<?= $list_meals->mp_id ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove From Favorite" data-bs-offset="-40,5" data-bs-trigger="hover" class="position-absolute btn btn-sm btn-danger add_fav_meal btn-meal-remove"><i class="fas fa-trash"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="Expand or Collapse" data-bs-offset="45,5" data-bs-trigger="hover" class="position-absolute btn btn-sm btn-success toggle_btn"><i class="fas fa-plus"></i></a>
                            <div class="time_plan_wrapper d-grid gap-2 text-center">
                                <p class="meal_description"><?= $list_meals->meal_desc ?></p>
                                <div class="time_plan alert alert-secondary mb-0 p-1">
                                    <p class="mb-0"><strong>Breakfast Time:</strong></p>
                                    <p class="mb-0"><?= date('h:i A', strtotime($list_meals->breakfast_time)); ?></p>
                                    <p class="mb-0"><?= $list_meals->breakfast_meal ?></p>
                                </div>
                                <div class="time_plan alert alert-secondary mb-0 p-1">
                                    <p class="mb-0"><strong>Snack Time:</strong></p>
                                    <p class="mb-0"><?= date('h:i A', strtotime($list_meals->snack_time)); ?></p>
                                    <p class="mb-0"><?= $list_meals->snack_meal ?></p>
                                </div>
                                <div class="time_plan alert alert-secondary mb-0 p-1">
                                    <p class="mb-0"><strong>Lunch Time:</strong></p>
                                    <p class="mb-0"><?= date('h:i A', strtotime($list_meals->lunch_time)); ?></p>
                                    <p class="mb-0"><?= $list_meals->lunch_meal ?></p>
                                </div>
                                <div class="time_plan alert alert-secondary mb-0 p-1">
                                    <p class="mb-0"><strong>Dinner Time:</strong></p>
                                    <p class="mb-0"><?= date('h:i A', strtotime($list_meals->dinner_time)); ?></p>
                                    <p class="mb-0"><?= $list_meals->dinner_meal ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <h3 class="alert alert-secondary text-center">No Meal Plan Available Right Now.</h3>
            <?php endif;
            $list_meals_Q->close();
            $db->next_result(); ?>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="RecipeDetails" tabindex="-1" aria-labelledby="RecipeDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="RecipeDetailsLabel">Recipe Details | <span id="category_name" class="text-success"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 id="title" class="text-center fs-2">Details will come here...</h2>
                            <div class="ingredients-wrapper my-4 ms-4">
                                <h3>Ingredients</h3>
                                <ul id="list_ingredients"></ul>
                            </div>
                            <p id="instructions" class="px-4"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <span>Recipe By: <span id="nutritionist_name" class="text-secondary"></span></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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

            $(".btn-recipe-details").on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: 'ajax/recipe_details.php',
                    method: 'POST',
                    data: {
                        recipe_id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#title").html(res.title);
                        $("#list_ingredients").addClass('count_' + res.list_count).html(res.ingredients_list);
                        $("#instructions").html(res.instructions);
                        $("#nutritionist_name").html(res.nutritionist);
                        $("#category_name").html(res.category_name);
                    }
                });
            });

            // Remove Recipe
            $(".btn-recipe-fav").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                let usrID = $(this).data("usr");
                $(this).css({
                    'pointer-events': 'none',
                    'background-color': '#777',
                    'border-color': '#777'
                });
                $.ajax({
                    url: "ajax/delete.php",
                    method: "POST",
                    data: {
                        fav_id: id,
                        table_column: 'fav_recipes'
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".toast").addClass(res.class_);
                        $(".toast-body").html(res.msg);
                        toast.show();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                })
            });

            // Meal Plan Toggle
            $(".toggle_btn").on('click', function(e) {
                e.preventDefault();
                if ($(this).children('i').hasClass('fa-minus')) {
                    $(this).children('i').removeClass('fa-minus').addClass('fa-plus');
                } else {
                    $(this).children('i').removeClass('fa-plus').addClass('fa-minus');
                }
                $(this).next().toggleClass('active');
            });

            // Remove Meal Plan
            $(".btn-meal-remove").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                $(this).css({
                    'pointer-events': 'none',
                    'background-color': '#777',
                    'border-color': '#777'
                });
                $.ajax({
                    url: "ajax/delete.php",
                    method: "POST",
                    data: {
                        fav_id: id,
                        table_column: 'fav_meals'
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".toast").addClass(res.class_);
                        $(".toast-body").html(res.msg);
                        toast.show();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                })
            });

        });
    </script>
</body>

</html>