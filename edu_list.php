<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Content | <?= TITLE ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="edu_list">
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto my-5 list-wrapper">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Educational Content List</h1>
            </div>
            <?php
            $edu_list_Q = $db->query("CALL `get_edu_list`()");
            if (mysqli_num_rows($edu_list_Q) > 0):
                while ($edu_list = mysqli_fetch_object($edu_list_Q)):
            ?>
                    <div class="col-12 col-md-6 mb-4">
                        <div class="content d-flex flex-wrap">
                            <div class="img d-flex align-items-center col-12 col-md-4">
                                <img src="img/edu/<?= $edu_list->edu_image ?>" alt="recipe_img_<?= $edu_list->edu_id ?>" class="h-100 object-fit-cover rounded">
                            </div>
                            <div class="text-content-wrapper p-2 col-12 col-md-8">
                                <h3><?= $edu_list->edu_title ?></h3>
                                <p class="text-justify"><?= $edu_list->edu_desc ?></p>
                                <div class="buttons_wrapper d-flex justify-content-center w-100 gap-2">
                                    <a href="pdf/<?= $edu_list->edu_pdf ?>" download class="content-center btn btn-primary w-75">Download PDF</a>
                                    <a href="<?= $edu_list->edu_link ?>" target="_blank" class="content-center btn btn-danger w-25">
                                        <i class="fs-4 fab fa-youtube"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <h3 class="alert alert-secondary text-center">No Content Available Right Now.</h3>
            <?php endif;
            $edu_list_Q->close();
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
                    'background-color': '#777',
                    'border-color': '#777'
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
                        // }
                        setTimeout(() => {
                            $(".btn-recipe-fav").removeAttr('style');
                            // window.location.reload();
                        }, 1000);
                    }
                })
            });
        });
    </script>

</body>

</html>