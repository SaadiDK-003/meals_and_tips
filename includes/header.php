<header>
    <div class="container mx-auto">
        <div class="row">
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="logo">
                    <h3 class="text-white mb-0">LOGO</h3>
                </div>
            </div>
            <div class="col-8 d-flex align-items-center justify-content-center">
                <ul class="nav d-flex gap-5">
                    <li>
                        <a class="fs-4" href="#!">Home</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">About</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="nav-buttons">
                    <?php if (isLoggedin()): ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>