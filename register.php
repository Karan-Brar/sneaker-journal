<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Register</title>
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
        <a href="login.php">Already a user? Sign in</a>
        <a href="index.php">Back to home page</a>
    </form>
</body>

</html>