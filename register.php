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
    <title><?= TITLE ?> | Register</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="register">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <?php
                if (isset($_POST['email']) && isset($_POST['password'])):
                    echo register($_POST);
                endif;
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center">Register</h2>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="username" autofocus name="username" id="username" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select type="role" name="role" id="role" required class="form-select">
                                    <option value="" selected hidden>Select Role</option>
                                    <option value="user">User</option>
                                    <option value="nutritionist">Nutritionist</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <a class="btn btn-success" href="login.php">LOGIN</a>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary d-block ms-auto">
                                    REGISTER
                                </button>
                            </div>
                            <a href="./" class="d-block mx-auto text-center mt-4 text-decoration-none">Back to home page.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/external_js.php'; ?>
</body>

</html>