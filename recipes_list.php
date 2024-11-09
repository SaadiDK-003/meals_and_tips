<?php
require_once 'core/database.php';
// if (!isLoggedin()) {
//     header('Location: login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes List | <?= TITLE ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="recipes_list">
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto my-5 list-wrapper">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-3">Recipes List</h1>
            </div>
            <?php
            $list_recipes_Q = $db->query("CALL `get_recipes_list_approved`()");
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
                            <div class="buttons_wrapper d-flex justify-content-center w-100 gap-2">
                                <a href="#!" data-id="<?= $list_recipes->recipe_id ?>" data-bs-toggle="modal" data-bs-target="#RecipeDetails" class="btn-recipe-details btn btn-primary w-75">Details</a>
                                <a href="#!" data-id="<?= $list_recipes->recipe_id ?>" data-usr="<?= $userID ?>" class="btn-recipe-fav btn btn-danger w-25">
                                    <i class="fas fa-star"></i>
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
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {

            // Toast init
            const toastEl = document.querySelector('.toast');
            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
            });

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

            $(".btn-recipe-fav").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                let usrID = $(this).data("usr");
                $(this).css({
                    'pointer-events': 'none',
                    'background-color': '#777'
                });
                $.ajax({
                    url: "ajax/recipe_details.php",
                    method: "POST",
                    data: {
                        fav_id: id,
                        usrID: usrID
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if ($(".toast").hasClass('text-bg-danger')) {
                            $(".toast").removeClass('text-bg-danger');
                        }
                        $(".toast").addClass(res.class_);
                        $(".toast-body").html(res.msg);
                        toast.show();
                        // if (res.status == 'success') {
                        //     setTimeout(() => {
                        //         window.location.reload();
                        //     }, 2000);
                        // }
                    }
                })
            });
        });
    </script>

</body>

</html>