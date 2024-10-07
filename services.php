<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | About</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
    <style>
        /* Section Styles */
        /* .image-container {
            background-color: #005772;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            text-align: center;
            color: white;
            padding: 20px;
        } */

        /* Image Styles */
        .image-container img {
            border: 1px solid #00000038;
            padding: 20px;
            max-width: 100%;
            max-height: 60%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Text Styles */
        .image-container h3 {
            margin-top: 20px;
            font-size: 40px;
            line-height: 1.5;
            max-width: 600px;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="home_page">

    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="hero __about">
            <div class="container">
                <div class="content hero-about-content">
                    <h4 class="bg-primary-custom text-white px-5 py-3 rounded-3 fs-1">Services</h4>
                </div>
            </div>
        </section>
        <section class="services">
            <div class="container">
                <div class="row">
                    <div class="col-12 my-5">
                        <div class="owl-carousel">
                            <?php
                            $service_Q = $db->query("SELECT * FROM `services`");
                            while ($list_service = mysqli_fetch_object($service_Q)):
                            ?>
                                <div class="image-container">
                                    <img width="230" height="600" src="<?= $list_service->img ?>" alt="<?= $list_service->service_name ?>">
                                    <h4 class="text-center mt-3"><?= $list_service->service_name ?></h4>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>


    <?php include './includes/js_links.php'; ?>
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: false,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        });
    </script>
</body>

</html>