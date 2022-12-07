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
    <title>IceFeet - New Brand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <?php if (isset($_GET['invalid-brand'])) : ?>
        <h2>Invalid Brand!</h2>
    <?php endif ?>
    <form action="processbrand.php" method="post" id="newPost">
        <div>
            <label for="name">Brand Name: </label>
            <input type="text" name="name" id="name" required="required">
        </div>

        <input type="submit" name="command" value="Create" id="createBtn">
        <a href="brands.php">Cancel</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>