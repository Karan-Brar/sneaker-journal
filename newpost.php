<?php

require 'connect.php';

session_start();

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: ./index.php?not_logged_in=true");
}

$query = "SELECT * FROM brand";
$statement = $db->prepare($query);
$statement->execute();
$brands = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - New Sneaker Posting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php require 'header.php' ?>
    <?php if (isset($_GET['invalid-post'])) : ?>
        <h2>Invalid Post!</h2>
    <?php endif ?>
    <form action="processpost.php" method="post" id="newPost" enctype="multipart/form-data">
        <div>
            <label for="name">Shoe Name: </label>
            <input type="text" name="name" id="name" required="required">
        </div>

        <div>
            <label for="description">Shoe Info: </label>
            <textarea name="description" id="description" cols="30" rows="10" required="required"></textarea>
        </div>

        <div>
            <label for="price">Shoe Price: </label>
            $<input type="number" name="price" id="price" required="required">
        </div>

        <div>
            <label for="releaseDate">Release Date: </label>
            <input type="date" id="releaseDate" name="releaseDate" required="required">
        </div>

        <div>
            <label for="brands">Shoe Brand: </label>
            <select name="brands" id="brands" required="required">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label for='image'>Sneaker Image (Optional): </label>
            <input type='file' name='image' id='image'>
        </div>



        <input type="submit" name="command" value="Create" id="createBtn">
        <a href="index.php">Cancel</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>