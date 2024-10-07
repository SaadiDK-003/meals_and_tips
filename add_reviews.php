<?php
require_once './core/database.php';
if (isLoggedin() === false || $userRole == 'doctor') {
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Reviews</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="reviews_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="reviews">
            <div class="container my-5">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1><?= TITLE ?> | Reviews</h1>
                    </div>
                    <div class="col-10 col-md-3 mx-auto">
                        <?php
                        if (isset($_POST['submit'])) :
                            echo add_reviews($_POST, $userID);
                        ?>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="">Rating</label>
                                        <div class="checkbox-group d-flex gap-2 align-items-center">
                                            <!-- one -->
                                            <div class="form-check">
                                                <input class="form-check-input d-none" name="stars[]" type="checkbox" id="one" value="1" />
                                                <label class="form-check-label" for="one">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                            <!-- two -->
                                            <div class="form-check">
                                                <input class="form-check-input d-none" name="stars[]" type="checkbox" id="two" value="2" />
                                                <label class="form-check-label" for="two">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                            <!-- three -->
                                            <div class="form-check">
                                                <input class="form-check-input d-none" name="stars[]" type="checkbox" id="three" value="3" />
                                                <label class="form-check-label" for="three">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                            <!-- four -->
                                            <div class="form-check">
                                                <input class="form-check-input d-none" name="stars[]" type="checkbox" id="four" value="4" />
                                                <label class="form-check-label" for="four">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                            <!-- five -->
                                            <div class="form-check">
                                                <input class="form-check-input d-none" name="stars[]" type="checkbox" id="five" value="5" />
                                                <label class="form-check-label" for="five">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="comments">Comments</label>
                                        <textarea rows="5" name="comments" id="comments" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="hidden" name="checked_count" id="checked-count" value="">
                                    <input type="hidden" name="res_id" id="res_id" value="<?= $_GET['res_id'] ?? '' ?>">
                                    <input type="hidden" name="doc_id" id="doc_id" value="<?= $_GET['doc_id'] ?? '' ?>">
                                    <div class="form-group d-flex justify-content-center justify-content-md-end">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include './includes/js_links.php'; ?>
    <script>
        $(document).ready(function() {
            $("#email").focus();

            setTimeout(() => {
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
            }, 200);

            $('.form-check-input').change(function() {
                var value = parseInt($(this).val());
                var isChecked = $(this).prop('checked');
                // Check or uncheck all stars up to the clicked star
                $('.form-check-input').each(function() {
                    var currentVal = parseInt($(this).val());

                    if (currentVal <= value && isChecked) {
                        $(this).prop('checked', true);
                    } else if (currentVal >= value) {
                        $(`input[value="${value}"]`).prop('checked', true);
                        $(this).prop('checked', false);
                    }
                });

                updateCheckedCount();
            });

            $('.form-check-label').hover(function() {
                var value = parseInt($(this).prev().val());

                $('.form-check-label i').each(function(index) {
                    if (index < value) {
                        $(this).css('color', 'gold');
                    } else {
                        $(this).css('color', '#acacac');
                    }
                });
            }, function() {
                $('.form-check-input:checked ~ .form-check-label i').css('color', 'gold');
                $('.form-check-input:not(:checked) ~ .form-check-label i').css('color', '#acacac');
            });

            function updateCheckedCount() {
                var checkedCount = $('.form-check-input:checked').length;
                $('#checked-count').val(checkedCount);
            }

            // Initial update
            updateCheckedCount();

        });
    </script>
</body>

</html>