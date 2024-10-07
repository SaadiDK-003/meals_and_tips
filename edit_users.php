<?php
require_once './core/database.php';
if ($userRole != 'admin') {
    header('Location: ./');
}
$getID = 0;
if (isset($_GET['id'])) {
    $getID = $_GET['id'];
}
$usr_Q = $db->query("SELECT * FROM `users` WHERE `id`='$getID'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Edit Users</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="edit_users_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="edit_users">
            <div class="container my-5">
                <?php
                if (mysqli_num_rows($usr_Q) > 0) :
                    $edit_data = mysqli_fetch_object($usr_Q);
                ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><?= TITLE ?> | Edit Users</h1>
                        </div>
                        <div class="col-10 col-md-6 mx-auto">
                            <?php
                            if (isset($_POST['submit'])) :
                                echo edit_user($_POST);
                            ?>
                            <?php endif; ?>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : $edit_data->name ?>" id="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : $edit_data->email ?>" id="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="tel" name="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : $edit_data->phone ?>" id="phone" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control">
                                            <code>leave blank if don't wanna change it.</code>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-3 d-flex align-items-end">
                                        <input type="hidden" name="user_id" value="<?= $edit_data->id ?>">
                                        <input type="hidden" name="old_pwd" value="<?= $edit_data->password ?>">
                                        <div class="form-group d-flex justify-content-center justify-content-md-end w-100">
                                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>No User Found.</h1>
                            <a href="./adminDashboard.php" class="btn btn-md btn-primary">Go Back</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>


    <?php include './includes/js_links.php'; ?>
</body>

</html>