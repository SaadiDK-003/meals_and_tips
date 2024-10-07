<?php
require_once './core/database.php';
if (isLoggedin() === true) {
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Login</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="login_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="login">
            <div class="container my-5">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1><?= TITLE ?> | Login</h1>
                    </div>
                    <div class="col-10 col-md-3 mx-auto">
                        <?php
                        if (isset($_POST['submit'])) :
                            $e = $_POST['email'];
                            $p = $_POST['password'];
                            echo login($e, $p);
                        ?>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group d-flex gap-2 justify-content-end">
                                        <!--<a href="./register.php" class="btn btn-secondary">Register</a>-->
                                        <button type="submit" name="submit" id="submit" class="btn btn-success">Login</button>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="./forgetPassword.php" class="btn btn-warning">forget your password?</a>
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
        });
    </script>
</body>

</html>