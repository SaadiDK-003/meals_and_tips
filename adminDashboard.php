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

<body id="adminDashboard">
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
                <div class="row">
                    <!-- In-Review Recipes List -->
                    <div class="col-12 mb-5">
                        <?php
                        $getRecipe_Q = $db->query("CALL `get_recipes_list_in_review`()");
                        if (mysqli_num_rows($getRecipe_Q) > 0):
                        ?>
                            <table id="example" class="align-middle text-center table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Ingredients</th>
                                        <th>Instructions</th>
                                        <th>Recipe Image</th>
                                        <th>Recipe Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($recipe_list = mysqli_fetch_object($getRecipe_Q)): ?>
                                        <tr>
                                            <td><?= $recipe_list->recipe_title ?></td>
                                            <td><?= $recipe_list->ingredients ?></td>
                                            <td><span title="<?= $recipe_list->instructions ?>" class="line-clamp-1"><?= $recipe_list->instructions ?></span>
                                            </td>
                                            <td>
                                                <img class="d-block mx-auto" src="img/recipe/<?= $recipe_list->recipe_img ?>" alt="recipe_img_<?= $recipe_list->recipe_id ?>" width="50" height="50">
                                            </td>
                                            <td>
                                                <?php if ($recipe_list->recipe_status == '0'): ?>
                                                    <span class="btn btn-secondary">in-review</span>
                                                <?php else: ?>
                                                    <span class="btn btn-success">approved</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="#!" data-id="<?= $recipe_list->recipe_id ?>" class="btn btn-sm btn-primary btn-update" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                                <a href="#!" data-id="<?= $recipe_list->recipe_id ?>" class="btn btn-sm btn-danger btn-del">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3 class="text-center alert alert-secondary">No Data Available.</h3>
                        <?php endif;
                        $getRecipe_Q->close();
                        $db->next_result(); ?>
                    </div>
                    <!-- Approved Recipes List -->
                    <div class="col-12">
                        <?php
                        $getRecipe1_Q = $db->query("CALL `get_recipes_list_approved`()");
                        if (mysqli_num_rows($getRecipe1_Q) > 0):
                        ?>
                            <table id="example1" class="align-middle text-center table table-striped table-bordered">
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
                                                <?php if ($recipe_list_->recipe_status == '0'): ?>
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
                            <!-- <h3 class="text-center">No Data Available.</h3> -->
                        <?php endif;
                        $getRecipe1_Q->close();
                        $db->next_result(); ?>
                    </div>
                </div>
            </div>
            <!-- Add Categories -->
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

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Recipe Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update_recipe_status">
                    <div class="modal-body">
                        <span id="showUpdMsg"></span>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="upd_recipe_status">Update Status</label>
                                    <select class="form-select" name="upd_recipe_status" id="upd_recipe_status">
                                        <option value="0">In Review</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="upd_recipe_id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast -->
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
                }, {
                    width: '10%'
                }]
            });

            new DataTable('#example1', {
                ordering: false,
                columns: [{
                    width: '15%'
                }, {
                    width: '15%'
                }, {
                    width: '30%'
                }, {
                    width: '5%'
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

            // Update Recipe Status

            $(document).on("click", ".btn-update", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                $("input[name='upd_recipe_id']").val(id);
            });

            $(document).on("submit", "#update_recipe_status", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'ajax/admin.php',
                    method: 'post',
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#showUpdMsg").addClass(res.status).html(res.msg);
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
                    url: 'ajax/delete.php',
                    method: 'post',
                    data: {
                        del_id: id
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