<?php
require_once 'core/database.php';
if ($userRole == 'nutritionist') {
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

    <div class="container mx-auto my-5 list-wrapper">
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
                                <!-- <a href="#!" onclick="alert('work in-progress')" data-id="< ?= $list_recipes->recipe_id ?>" class="btn-recipe-fav btn btn-danger w-25">
                                    <i class="fas fa-star"></i>
                                </a> -->
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


    <?php include_once 'includes/footer.php'; ?>
    <?php include_once 'includes/external_js.php'; ?>
</body>

</html>