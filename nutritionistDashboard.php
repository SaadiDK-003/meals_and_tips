<?php
require_once 'core/database.php';

if ($userRole != 'nutritionist') {
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist Dashboard</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="nutritionistDashboard">
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto mt-5 min-h-800">
        <div class="row">
            <div class="tab-buttons col-12 d-flex gap-3 justify-content-center">
                <a href="#!" class="btn btn-primary active">Add Recipes</a>
                <a href="#!" class="btn btn-secondary">Add Meal Plan</a>
                <a href="#!" class="btn text-white btn-custom-green">Add Educational Content</a>
            </div>
        </div>
        <div class="row content-wrapper">
            <!-- RECIPES SECTION -->
            <div class="col-12 mx-auto mt-4">
                <div class="row">
                    <div class="col-12 col-md-8 mx-auto mt-4">
                        <span class="showCatMsg"></span>
                        <form id="recipe-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="recipe-title">Recipe Title</label>
                                        <input type="text" autofocus name="recipe_title" id="recipe-title" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="ingredients">Ingredients</label>
                                        <input type="text" name="ingredients" id="ingredients" class="form-control" placeholder="abc,xyz like that..." required>
                                        <code>Add Ingredients separate by commas</code>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="recipe_img">recipe_img</label>
                                        <input type="file" name="recipe_img" id="recipe_img" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="category_type">Select Category</label>
                                        <select type="text" name="category_type" id="category_type" required class="form-select">
                                            <?= get_categories('categories'); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="instructions">Instructions</label>
                                        <textarea rows="3" name="instructions" id="instructions" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="nutritionist_id" value="<?= $userID ?>">
                                        <button type="submit" name="recipe_submit" id="recipe-submit" class="btn btn-custom-green d-block ms-auto">
                                            Add Recipe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-5">
                    <!-- Approved Recipes List -->
                    <div class="col-12 mb-3">
                        <h2 class="my-3">In-Review / Approved Recipes</h2>
                        <?php
                        $getRecipe_Q = $db->query("CALL `get_recipes_list_review_or_approved_by_id`($userID)");
                        if (mysqli_num_rows($getRecipe_Q) > 0):
                        ?>
                            <table id="example" class="align-middle table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Ingredients</th>
                                        <th>Instructions</th>
                                        <th>Recipe Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($recipe_list = mysqli_fetch_object($getRecipe_Q)): ?>
                                        <tr>
                                            <td><?= $recipe_list->recipe_title ?></td>
                                            <td><?= $recipe_list->ingredients ?></td>
                                            <td><span title="<?= $recipe_list->instructions ?>" class="line-clamp-1"><?= $recipe_list->instructions ?></span></td>
                                            <td>
                                                <?php if ($recipe_list->recipe_status == '0'): ?>
                                                    <span class="btn btn-secondary">In-Review</span>
                                                <?php else: ?>
                                                    <span class="btn btn-success">Approved</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3 class="alert alert-secondary text-center">No Data Available.</h3>
                        <?php endif;
                        $getRecipe_Q->close();
                        $db->next_result(); ?>
                    </div>

                    <!-- Rejected Recipes List -->
                    <div class="col-12 mb-5">
                        <h2 class="my-3">Rejected Recipes</h2>
                        <?php
                        $getRecipe1_Q = $db->query("CALL `get_recipes_list_rejected_by_id`($userID)");
                        if (mysqli_num_rows($getRecipe1_Q) > 0):
                        ?>
                            <table id="example1" class="align-middle table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Ingredients</th>
                                        <th>Instructions</th>
                                        <th>Recipe Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($recipe_list_ = mysqli_fetch_object($getRecipe1_Q)): ?>
                                        <tr>
                                            <td><?= $recipe_list_->recipe_title ?></td>
                                            <td><?= $recipe_list_->ingredients ?></td>
                                            <td><span title="<?= $recipe_list_->instructions ?>" class="line-clamp-1"><?= $recipe_list_->instructions ?></span></td>
                                            <td>
                                                <span class="btn btn-danger">Rejected</span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3 class="alert alert-secondary text-center">No Data Available.</h3>
                        <?php endif;
                        $getRecipe1_Q->close();
                        $db->next_result(); ?>
                    </div>
                </div>
            </div>
            <!-- MEAL PLAN -->
            <div class="col-12 col-md-8 mx-auto my-5 d-none">
                <form id="meal-form">
                    <span id="mealMsg"></span>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="plan_title">Meal Plan Title</label>
                                <input name="plan_title" id="plan_title" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="cat_id">Category</label>
                                <select name="cat_id" id="cat_id" class="form-select" required>
                                    <?= get_categories('categories'); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="meal_desc">Meal Plan Description</label>
                                <input name="meal_desc" id="meal_desc" required class="form-control">
                            </div>
                        </div>
                        <!-- Breakfast -->
                        <div class="col-12 col-md-6 d-flex align-items-center mt-2">
                            <div class="form-group w-100">
                                <input type="text" name="breakfast_" value="Breakfast" class="form-control bg-success text-white" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3 col-md-6">
                            <div class="form-group">
                                <label for="breakfast-meal-time">Breakfast Time</label>
                                <input type="time" id="breakfast-meal-time" name="breakfast_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="breakfast_desc">Breakfast Description</label>
                                <input name="breakfast_meal" id="breakfast_desc" class="form-control" required>
                            </div>
                        </div>
                        <!-- Snack -->
                        <div class="col-12 col-md-6 d-flex align-items-center mt-2">
                            <div class="form-group w-100">
                                <input type="text" name="snack_" value="Snack" class="form-control bg-success text-white" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3 col-md-6">
                            <div class="form-group">
                                <label for="snack-meal-time">Snack Time</label>
                                <input type="time" id="snack-meal-time" name="snack_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="snack_desc">Snack Description</label>
                                <input name="snack_meal" id="snack_desc" class="form-control" required>
                            </div>
                        </div>
                        <!-- Lunch -->
                        <div class="col-12 col-md-6 d-flex align-items-center mt-2">
                            <div class="form-group w-100">
                                <input type="text" name="lunch_" value="Lunch" class="form-control bg-success text-white" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3 col-md-6">
                            <div class="form-group">
                                <label for="lunch-meal-time">Lunch Time</label>
                                <input type="time" id="lunch-meal-time" name="lunch_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="lunch_desc">Lunch Description</label>
                                <input name="lunch_meal" id="lunch_desc" class="form-control" required>
                            </div>
                        </div>
                        <!-- Dinner -->
                        <div class="col-12 col-md-6 d-flex align-items-center mt-2">
                            <div class="form-group w-100">
                                <input type="text" name="dinner_" value="Dinner" class="form-control bg-success text-white" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3 col-md-6">
                            <div class="form-group">
                                <label for="dinner-meal-time">Dinner Time</label>
                                <input type="time" id="dinner-meal-time" name="dinner_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="dinner_desc">Dinner Description</label>
                                <input name="dinner_meal" id="dinner_desc" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary d-block ms-auto">Add Meal Plan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Add Educational Content -->
            <div class="col-12 mx-auto d-none">
                <div class="row">
                    <div class="col-12 col-md-8 mx-auto mt-5">
                        <span class="showEduMsg"></span>
                        <form id="edu-form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="edu_title">Title</label>
                                        <input type="text" name="edu_title" id="edu_title" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="edu_link">Video Link</label>
                                        <input type="url" name="edu_link" id="edu_link" class="form-control" required placeholder="link of youtube video">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="edu_image">Image</label>
                                        <input type="file" class="form-control" required name="edu_image" id="edu_image">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="edu_pdf">PDF File (for download)</label>
                                        <input type="file" class="form-control" required name="edu_pdf" id="edu_pdf">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="edu_description">Description</label>
                                        <textarea rows="3" required name="edu_description" id="edu_description" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="edu_nutritionist_id" value="<?= $userID ?>">
                                        <button type="submit" name="edu_submit" id="edu_submit" class="btn btn-custom-green d-block ms-auto">
                                            Add Edu Content
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>


    <script>
        $(document).ready(function() {

            // Table Work
            const options = {
                ordering: false,
                "columns": [{
                    width: "12%"
                }, null, null, {
                    width: "10%"
                }]
            }
            let tLength = $("#example").length;
            let tLength1 = $("#example1").length;

            if (tLength > 0) {
                new DataTable('#example', options);
            }

            if (tLength1 > 0) {
                new DataTable('#example1', options);
            }

            // Tab Work
            $(document).on("click", ".tab-buttons a", function(e) {
                e.preventDefault();
                $(this).addClass("active").siblings().removeClass("active");
                let index = $(this).index() + 1;
                $(`.content-wrapper > div:nth-child(${index})`).removeClass("d-none").siblings().addClass("d-none");
            });


            // Category Form Submit
            $("#recipe-form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "ajax/nutritionist.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".showCatMsg").html(res.msg).addClass(res.class_);
                        if (res.status === 'success') {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1800);
                        } else {
                            setTimeout(() => {
                                $(".showCatMsg").html('').removeClass(res.class_);
                            }, 1500);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            // Educational Form Submit
            $("#edu-form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "ajax/nutritionist.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".showEduMsg").html(res.msg).addClass(res.class_);
                        if (res.status === 'success') {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1800);
                        } else {
                            setTimeout(() => {
                                $(".showEduMsg").html('').removeClass(res.class_);
                            }, 1500);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            // Meal Plan
            $("#meal-form").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'ajax/nutritionist.php',
                    method: 'post',
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#mealMsg").addClass(res.class_).html(res.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                })
            });
        });
    </script>
</body>

</html>