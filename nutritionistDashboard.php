<?php
require_once 'core/database.php';

if ($userRole != 'nutritionist') {
    header('Location: index.php');
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

<body>
    <?php include_once 'includes/header.php'; ?>

    <div class="container mx-auto mt-5">
        <div class="row">
            <div class="tab-buttons col-12 d-flex gap-3 justify-content-center">
                <a href="#!" class="btn btn-primary active">Add Recipes</a>
                <a href="#!" class="btn btn-secondary">Add Meal Plan</a>
            </div>
        </div>
        <div class="row content-wrapper">
            <div class="col-12 col-md-6 mx-auto mt-4">
                <span class="showCatMsg"></span>
                <form id="recipe-form">
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
                                <input type="text" name="ingredients" id="ingredients" class="form-control" placeholder="abc,xyz like that...">
                                <code>Add Ingredients separate by commas</code>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="instructions">Instructions</label>
                                <textarea rows="3" name="instructions" id="instructions" class="form-control"></textarea>
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
            <div class="col-12 mx-auto mt-4 d-none">
                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011-04-25</td>
                            <td>$320,800</td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011-07-25</td>
                            <td>$170,750</td>
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td>2009-01-12</td>
                            <td>$86,000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>



    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>


    <script>
        $(document).ready(function() {
            new DataTable('#example', {
                ordering: false,
                responsive: true
            });

            $(document).on("click", ".tab-buttons a", function(e) {
                e.preventDefault();
                $(this).addClass("active").siblings().removeClass("active");
                let index = $(this).index() + 1;
                $(`.content-wrapper > div:nth-child(${index})`).removeClass("d-none").siblings().addClass("d-none");
            });


            // Category Form Submit
            $("#recipe-form").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/nutritionist.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".showCatMsg").html(res.msg).addClass(res.status);
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