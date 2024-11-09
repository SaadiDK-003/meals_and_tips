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
            while ($list_recipes = mysqli_fetch_object($list_recipes_Q)):
            ?>
                <div class="col-12 col-md-3 mb-4">
                    <div class="content">
                        <div class="img">
                            <img src="img/recipe/<?= $list_recipes->recipe_img ?>" alt="recipe_img_<?= $list_recipes->recipe_id ?>">
                        </div>
                        <h3 class="mb-0 text-center"><?= $list_recipes->recipe_title ?></h3>
                        <p class="mb-0 text-center"><?= $list_recipes->instructions ?></p>
                        <a href="#!" data-bs-toggle="modal" data-bs-target="#RecipeDetails" class="btn btn-primary w-100">Details</a>
                    </div>
                </div>
            <?php endwhile;
            $list_recipes_Q->close();
            $db->next_result(); ?>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="RecipeDetails" tabindex="-1" aria-labelledby="RecipeDetailsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="RecipeDetailsLabel">Recipe Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center fs-2">Details will come here...</h2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="upd_recipe_id" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
</body>

</html>