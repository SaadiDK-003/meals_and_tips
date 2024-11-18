<?php
require_once 'core/database.php';
if (!isLoggedin()) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Profile</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="user-profile">
    <?php include_once 'includes/header.php'; ?>

    <div class="container my-5">
        <form id="update-profile">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-3">My Profile</h2>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="showMsg"></span>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" value="<?= $userName ?>" class="form-control" id="username" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="<?= $userEmail ?>" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" value="<?= $userPhone ?>" class="form-control" id="phone">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" class="form-control" id="password">
                                <code class="text-nowrap">Leave it, if you don't want to change.</code>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="current_pwd" value="<?= $userPwd ?>">
                            <button type="submit" class="btn btn-primary d-block ms-auto">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            $("#update-profile").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'ajax/profile.php',
                    method: 'post',
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == 'error') {
                            $(".showMsg").removeClass('alert-success');
                        }
                        $(".showMsg").addClass(res.class_).html(res.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                });
            });
        });
    </script>
</body>

</html>