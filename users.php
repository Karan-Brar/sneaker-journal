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
</head>

<body>
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
</body>

</html>