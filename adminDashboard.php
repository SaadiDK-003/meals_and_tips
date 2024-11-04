<?php
require_once 'core/database.php';

if ($userRole != 'admin') {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body>
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto mt-5">
        <div class="row">
            <div class="tab-buttons col-12 d-flex gap-3 justify-content-center">
                <a href="#!" class="btn btn-secondary">Approve Recipes</a>
                <a href="#!" class="btn btn-primary active">Add Categories</a>
            </div>
        </div>
        <div class="row content-wrapper">
            <div class="col-12 mx-auto mt-4">
                <?php
                $getRecipe_Q = $db->query("CALL `get_recipes_list`()");
                if (mysqli_num_rows($getRecipe_Q) > 0):
                ?>
                    <table id="example" class="align-middle text-center table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Ingredients</th>
                                <th>Instructions</th>
                                <th>Recipe Status</th>
                                <th>Action</th>
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
                                            <span class="btn btn-secondary">in-review</span>
                                        <?php else: ?>
                                            <span class="btn btn-success">approved</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="#!" data-id="<?= $recipe_list->recipe_id ?>" class="btn btn-sm btn-danger btn-del">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h3 class="text-center">No Data Available.</h3>
                <?php endif;
                $getRecipe_Q->close();
                $db->next_result(); ?>
            </div>
            <div class="col-12 col-md-3 mx-auto mt-4 d-none">
                <span class="showCatMsg"></span>
                <form id="cat-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="category-name">Category Name</label>
                                <input type="text" autofocus name="category_name" id="category-name" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-3 d-none">
                            <div class="form-group">
                                <label for="category-img">Category Image</label>
                                <input type="file" name="category_img" id="category-img" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" name="category_submit" id="category-submit" class="btn btn-custom-green d-block ms-auto">
                                    Add Category
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Hello, world! This is a toast message.
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

            // DataTable
            new DataTable('#example', {
                ordering: false,
                columns: [{
                    width: '20%'
                }, {
                    width: '20%'
                }, {
                    width: '30%'
                }, {
                    width: '10%'
                }, {
                    width: '10%'
                }]
            });

            // Tabs Switch
            $(document).on("click", ".tab-buttons a", function(e) {
                e.preventDefault();
                $(this).addClass("active").siblings().removeClass("active");
                let index = $(this).index() + 1;
                $(`.content-wrapper > div:nth-child(${index})`).removeClass("d-none").siblings().addClass("d-none");
            });


            // Category Form Submit
            $("#cat-form").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/admin.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".showCatMsg").html(res.msg).addClass(res.status);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                });
            });

            // Delete Recipe
            $(document).on("click", ".btn-del", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: 'ajax/admin.php',
                    method: 'post',
                    data: {
                        del_recipe_id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".toast").addClass(res.status);
                        $(".toast .toast-body").html(res.msg);
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