<header>
    <div class="container mx-auto">
        <div class="row">
            <div class="col-3 d-flex align-items-center justify-content-center">
                <div class="logo">
                    <a href="./" class="text-decoration-none">
                        <h3 class="text-white mb-0"><?= TITLE ?></h3>
                    </a>
                </div>
            </div>
            <div class="col-7 d-flex align-items-center justify-content-center">
                <ul class="nav d-flex gap-5">
                    <li>
                        <a class="fs-4" href="./">Home</a>
                    </li>
                    <li>
                        <a class="fs-4" href="./recipes_list.php">Recipes</a>
                    </li>
                    <li>
                        <a class="fs-4" href="./meals_plan_list.php">Meals Plan</a>
                    </li>
                    <li>
                        <a class="fs-4" href="./edu_list.php">Educational Content</a>
                    </li>
                </ul>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="nav-buttons">
                    <?php if (isLoggedin()): ?>
                        <?php if ($userRole == 'admin'): ?>
                            <a href="./adminDashboard.php" class="btn btn-success">Dashboard</a>
                        <?php elseif ($userRole == 'nutritionist'): ?>
                            <a href="./nutritionistDashboard.php" class="btn btn-success">Dashboard</a>
                        <?php else: ?>
                            <a href="./userDashboard.php" class="btn btn-success">Dashboard</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>