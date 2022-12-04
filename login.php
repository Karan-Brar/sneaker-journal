<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Log In</title>
</head>

<body>
    <?php if (isset($_GET['invalid-login'])) : ?>
        <h2>Invalid Login Attempt!</h2>
    <?php endif ?>
    <form action="authenticate.php" method="post" id="newPost">
        <div>
            <label for="name">Username: </label>
            <input type="text" name="username" id="username" required="required">
        </div>

        <div>
            <label for="pass">Password: </label>
            <input type="password" name="pass" id="pass" required="required">
        </div>
        <input type="submit" name="command" value="Login" id="createBtn">
        <a href="register.php">Not a user? Register</a>
        <a href="index.php">Back to home page</a>
    </form>
</body>

</html>