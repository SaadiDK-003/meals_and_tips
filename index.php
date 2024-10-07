<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Home</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="home_page">

    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="hero">
            <div class="container">
                <div class="content hero-content">
                    <h1>MY DOCTOR CLINIC</h1>
                    <div class="text-center">
                        <h2 class="text-center text-white">Browse Your Doctors</h2>
                        <a href="doctors.php" class="btn btn-primary">Browse Your Doctors</a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php
                    $get_r_Q = $db->query("CALL `get_last_five_reviews`()");
                    if (mysqli_num_rows($get_r_Q) > 0) :
                    ?>
                        <div class="col-12 mt-4 mb-2">
                            <h3 class="text-center">Reviews</h3>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="cafe-reviews owl-carousel">
                                <!-- item start -->
                                <?php
                                while ($reviews = mysqli_fetch_object($get_r_Q)) :
                                ?>
                                    <div class="item">
                                        <div class="review-card border border-2 rounded-2 p-4">
                                            <div class="users-name position-relative">
                                                <h6><?= $reviews->name ?></h6>
                                                <h5 class="position-absolute btn btn-secondary d-none"><?= $reviews->clinic_name ?></h5>
                                            </div>
                                            <div class="ratings mb-2 <?= 'rate-' . $reviews->rating ?>">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="text">
                                                <p><?= $reviews->comments ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <!-- item start end -->
                            </div>
                        </div>
                    <?php endif;
                    $get_r_Q->close();
                    $db->next_result(); ?>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>


    <?php include './includes/js_links.php'; ?>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.hero-content h1.smoke-text').addClass('smoke');
            }, 2800);

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
</body>

</html>