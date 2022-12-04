<?php

session_start();

if (isset($_SESSION['logged_in_user'])) {
    if (!($_SESSION['logged_in_user']['admin_access'] === 1)) {
        header("Location: ./index.php");
    }
} else {
    header("Location: ./index.php");
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - New User</title>
</head>

<body>
    <?php if (isset($_GET['invalid-user'])) : ?>
        <h2>Invalid User!</h2>
    <?php endif ?>
    <form action="processuser.php" method="post" id="newPost">

        <div>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" required="required">
        </div>

        <div>
            <label for="pass">Password: </label>
            <input type="password" name="pass" id="pass" required="required">
        </div>

        <div>
            <label for="repass">Re-Enter Password: </label>
            <input type="password" name="repass" id="repass" required="required">
        </div>
        <input type="submit" name="command" value="Register" id="createBtn">
        <a href="users.php">Back to User List</a>
    </form>
</body>

</html>