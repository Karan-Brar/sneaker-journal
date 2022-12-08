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
    <div class="container">
        <?php if (isset($_GET['invalid-post'])) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Invalid Post!
            </div>
        <?php endif ?>
        <form class="mt-4" action="processpost.php" method="post" id="newPost" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" for="name">Shoe Name</label>
                <input class="form-control" type="text" name="name" id="name" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Shoe Info</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required="required"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="price">Shoe Price($)</label>
                <input class="form-control" type="number" name="price" id="price" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label" for="releaseDate">Release Date: </label>
                <input class="form-control" type="date" id="releaseDate" name="releaseDate" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label" for="brands">Shoe Brand: </label>
                <select class="form-control" name="brands" id="brands" required="required">
                    <?php foreach ($brands as $brand) : ?>
                        <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for='image'>Sneaker Image (Optional): </label>
                <input class="form-control" type='file' name='image' id='image'>
            </div>

            <div class="mb-3">
                <button type="submit" name="command" value="Create" class="btn btn-primary">Create</button>
                <a class="btn btn-light" role="button" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>