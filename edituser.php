<?php

require 'connect.php';

session_start();

if (isset($_SESSION['logged_in_user'])) {
    if (!($_SESSION['logged_in_user']['admin_access'] === 1)) {
        header("Location: ./index.php");
    }
} else {
    header("Location: ./index.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
} else {
    $user_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM user WHERE user_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($user_id));
    $statement->execute();
    $user = $statement->fetch();

    if (!$user) {
        header("Location: ./users.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <?php if (isset($_GET['invalid-user'])) : ?>
            <h2>Invalid User Edit!</h2>
        <?php endif ?>
        <form action="processuser.php" method="post" id="editBrand">
            <input type="hidden" name="id" value="<?= $user_id ?>" />
            <div>
                <label for="name">User Name: </label>
                <input type="text" name="name" id="name" value="<?= $user['username'] ?>">
            </div>

            <div>
                <label for="admin-access">Admin Access: </label>
                <?php if ($user['admin_access'] === 1) : ?>
                    <input type="checkbox" name="admin-access" id="admin-access" value="Yes" checked>
                <?php else : ?>
                    <input type="checkbox" name="admin-access" id="admin-access" value="Yes">
                <?php endif ?>
            </div>

            <input type="submit" name="command" value="Update" id="updateBtn">
            <input type="submit" name="command" value="Delete" id="deleteBtn">
            <a href="users.php">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>