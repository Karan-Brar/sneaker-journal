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
    <title>Blogzilla - Post New Blog</title>
</head>

<body>
    <form action="processbrand.php" method="post" id="newPost">
        <div>
            <label for="name">Brand Name: </label>
            <input type="text" name="name" id="name" required="required">
        </div>

        <input type="submit" name="command" value="Create" id="createBtn">
        <a href="brands.php">Cancel</a>
    </form>
</body>

</html>