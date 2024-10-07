<?php
require_once './core/database.php';
if ($userRole != 'admin') {
    header('Location: ./');
}
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

<body class="add_users_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="add_users">
            <div class="container my-5">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1><?= TITLE ?> | Edit Users</h1>
                    </div>
                    <div class="col-10 col-md-6 mx-auto">
                        <?php
                        if (isset($_POST['submit'])) :
                            echo add_user($_POST);
                        ?>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="tel" name="phone" id="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-select" required>
                                            <option value="" selected hidden>Select Role</option>
                                            <option value="visitor">Visitor</option>
                                            <option value="cafe_owner">Cafe Owner</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-group d-flex justify-content-center justify-content-md-end w-100">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
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
</body>

</html>