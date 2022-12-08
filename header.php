<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">IceFeet</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($_SESSION['logged_in_user'])) : ?>
                <li class="nav-item"><a class="nav-link disabled" href="#"><mark>Hello <?= $_SESSION['logged_in_user']['username'] ?></mark></a></li>
                <?php if ($_SESSION['logged_in_user']['admin_access'] === 1) : ?>
                    <li class="nav-item"><a class="nav-link" href="brands.php">Brand List</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">User List</a></li>
                <?php endif ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <?php endif ?>
        </ul>
    </div>
</nav>