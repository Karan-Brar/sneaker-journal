<?php
session_start();
?>

<nav>
    <?php if (isset($_SESSION['logged_in_user'])) : ?>
        <h4>Hello <?= $_SESSION['logged_in_user']['username'] ?></h4>
        <?php if ($_SESSION['logged_in_user']['admin_access'] === 1) : ?>
            <a href="brands.php">Brand List</a>
            <a href="users.php">User List</a>
        <?php endif ?>
        <a href="logout.php">Log Out</a>
    <?php else : ?>
        <a href="login.php">Log In</a>
        <a href="register.php">Register</a>
    <?php endif ?>
</nav>
