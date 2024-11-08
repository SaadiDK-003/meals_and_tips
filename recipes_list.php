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
                <div class="col-3">
                    <div class="content">
                        <div class="img">
                            <img src="img/recipe/<?= $list_recipes->recipe_img ?>" alt="recipe_img_<?= $list_recipes->recipe_id ?>">
                        </div>
                        <h3 class="mb-0 text-center"><?= $list_recipes->recipe_title ?></h3>
                        <p class="mb-0 text-center"><?= $list_recipes->instructions ?></p>
                        <a href="#!" class="btn btn-primary w-100">Details</a>
                    </div>
                </div>
            <?php endwhile;
            $list_recipes_Q->close();
            $db->next_result(); ?>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
</body>

</html>