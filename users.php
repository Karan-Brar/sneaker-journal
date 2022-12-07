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

$query = "SELECT * FROM user";
$statement = $db->prepare($query);
$statement->execute();
$users = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IceFeet - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div>
        <a href="newbrand.php">Create New User</a>
        <h1>User List - </h1>
        <?php foreach ($users as $user) : ?>
            <ul>
                <li><?= $user['username'] ?></li>
                <a href="edituser.php?id=<?= $user['user_id'] ?>">Edit User</a>
            </ul>
        <?php endforeach ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>