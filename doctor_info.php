<?php
require_once './core/database.php';
if (isLoggedin() === false) {
    header('Location: ./login.php');
}
$doc_id = 0;
$doc_name = '';
if (isset($_GET['doc_id']) && isset($_GET['doc_name'])) {
    $doc_id = $_GET['doc_id'];
    $doc_name = $_GET['doc_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Cafe Menu</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="cafe_menu_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="cafe_menu">
            <div class="container my-5">
                <div class="row">
                    <?php
                    $prod_Q = $db->query("CALL `get_all_products_by_cafe_id`($doc_id)");
                    if (mysqli_num_rows($prod_Q) > 0) : ?>
                        <div class="col-12">
                            <h3 class="text-center mb-3"><?= $doc_name ?></h3>
                        </div>
                        <?php
                        while ($list_p = mysqli_fetch_object($prod_Q)) :
                        ?>
                            <div class="col-10 col-md-3 mx-auto mx-md-0 mb-4">
                                <div class="card border rounded-2 p-2 d-flex justify-content-between">
                                    <div class="img overflow-hidden rounded-2">
                                        <img src="<?= $list_p->prod_img ?>" class="w-100" alt="product-img">
                                    </div>
                                    <div class="content position-relative">
                                        <div class="title d-flex align-items-center justify-content-between">
                                            <h5><?= $list_p->prod_name ?></h5><span class="bg-secondary text-white px-2 py-1 rounded-2 category h6"><?= $list_p->category_name ?></span>
                                        </div>
                                        <?php if ($list_p->prod_disc_price != 0.00) : ?>
                                            <span class="disc-price fw-bold text-success"><?= CURRENCY ?><?= $list_p->prod_disc_price ?></span>
                                            <span class="reg-price text-decoration-line-through text-danger"><?= CURRENCY ?><?= $list_p->prod_reg_price ?></span>
                                        <?php else : ?>
                                            <span class="reg-price fw-bold"><?= CURRENCY ?><?= $list_p->prod_reg_price ?></span>
                                        <?php endif; ?>
                                        <p class="line-clamp-2"><?= $list_p->prod_desc ?></p>
                                        <a href="#!" data-id="<?= $list_p->cafe_id ?>" class="btn btn-primary btn-sm cafe-info d-none">Cafe Info</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    else : ?>
                        <div class="col-12 text-center">
                            <h3 class="text-center">Sorry, no products found.</h3>
                            <a href="./" class="btn btn-primary">Home</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="cafeInfoModal" tabindex="-1" aria-labelledby="cafeInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title cafeName" id="cafeInfoModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-12">
                            <h4 class="bg-secondary text-white pt-2 pb-1 text-uppercase rounded-2">Owner Info</h4>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text">
                                <h5>Name</h5>
                                <h6 id="ownerName"></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text">
                                <h5>Phone</h5>
                                <h6 id="ownerPhone"></h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="bg-secondary text-white pt-2 pb-1 text-uppercase rounded-2">Shop Info</h4>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text">
                                <h5>Location</h5>
                                <h6 id="shopLocation"></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text">
                                <h5>Shop Timing</h5>
                                <h6 id="shopOpen"></h6>
                                <h6 id="shopClose"></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php include './includes/js_links.php'; ?>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".cafe-info", function(e) {
                e.preventDefault();
                $('#cafeInfoModal').modal('show');
                let cafeID = $(this).data("id");
                $.ajax({
                    url: 'ajax/doc_info.php',
                    method: 'post',
                    data: {
                        cafeID_modal: cafeID
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $(".cafeName").html(res.cafeName);
                        $("#ownerName").html(res.ownerName);
                        $("#ownerPhone").html(res.ownerPhone);
                        $("#shopLocation").html(res.shopLocation);
                        $("#shopOpen").html('open: ' + res.shopOpen);
                        $("#shopClose").html('close: ' + res.shopClose);
                    }
                });
            });
        });
    </script>
</body>

</html>