<?php
require_once './core/database.php';
if (isLoggedin() === false) {
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Edit Profile</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="edit_users_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <?php
        $getID = 0;
        $role_check = '';
        if (isset($_GET['u_id'])) {
            $getID = $_GET['u_id'];
            $role_check = $_GET['role_check'] ?? '';
            $usr_Q = $db->query("SELECT * FROM `users` WHERE `id`='$getID'");
        ?>
            <section class="edit_users">
                <div class="container my-5">
                    <?php
                    if (mysqli_num_rows($usr_Q) > 0) :
                        $edit_data = mysqli_fetch_object($usr_Q);
                    ?>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h1><?= TITLE ?> | Edit Profile</h1>
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
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" name="dob" value="<?= isset($_POST['dob']) ? $_POST['dob'] : $edit_data->dob ?>" id="dob" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-select">
                                                    <option value="Male" <?= ($edit_data->gender == 'Male') ? 'selected' : '' ?>>Male</option>
                                                    <option value="Female" <?= ($edit_data->gender == 'Female') ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" name="city" value="<?= isset($_POST['dob']) ? $_POST['dob'] : $edit_data->city ?>" id="city" class="form-control" required>
                                            </div>
                                        </div>
                                        <?php if ($clinic__ID != '' || $role_check == 'doctor'): ?>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="certificate">Certificate</label>
                                                    <select class="form-select" name="certificate" id="certificate" required>
                                                        <option selected hidden value="<?= isset($_POST['certificate']) ? $_POST['certificate'] : $edit_data->certificate ?>"><?= isset($_POST['certificate']) ? $_POST['certificate'] : $edit_data->certificate ?></option>
                                                        <?php $get_services_Q = $db->query("SELECT * FROM `services`");
                                                        while ($get_services = mysqli_fetch_object($get_services_Q)):
                                                        ?>
                                                            <option value="<?= $get_services->service_name ?>"><?= $get_services->service_name ?></option>
                                                        <?php endwhile; ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="experience">Experience</label>
                                                    <input type="text" name="experience" value="<?= isset($_POST['experience']) ? $_POST['experience'] : $edit_data->experience ?>" id="experience" class="form-control" required>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="diseases">Diseases</label>
                                                    <input type="text" name="diseases" value="<?= isset($_POST['diseases']) ? $_POST['diseases'] : $edit_data->diseases ?>" id="diseases" class="form-control" required>
                                                </div>
                                            </div>
                                        <?php endif; ?>

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
                                            <input type="hidden" name="user_role" value="<?= ($userRole == 'admin' ? $role_check : $userRole) ?>">
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
        <?php } ?>
        <?php
        if (isset($_GET['profile_id'])) {
        ?>
            <section class="edit_users">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><?= TITLE ?> | Edit Picture</h1>
                        </div>
                        <div class="col-10 col-md-4 mx-auto">
                            <?php
                            if (isset($_POST['submit'])) :
                                echo profile_pic($_POST, $_FILES);
                            ?>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="profile_pic">Profile Picture</label>
                                            <input type="file" name="profile_pic" id="profile_pic" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-3 d-flex align-items-end">
                                        <div class="form-group d-flex justify-content-center justify-content-md-end w-100">
                                            <input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">
                                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
    </main>


    <?php include './includes/js_links.php'; ?>
</body>

</html>