<?php
require_once 'core/database.php';
if (isLoggedin()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Forget Password</title>
    <?php include_once 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="forgetPassword">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 mx-auto">
                <?php
                if (isset($_POST['email']) && isset($_POST['phone'])):
                    echo forgetPassword($_POST['email'], $_POST['phone']);
                endif;
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center">Forget Password</h2>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" autofocus name="email" id="email" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <a class="btn btn-success" href="login.php">LOGIN</a>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                    SUBMIT
                                </button>
                            </div>
                            <a href="./" class="d-block text-center mt-4 text-decoration-none">Back to home page.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include 'includes/external_js.php'; ?>
</body>

</html>