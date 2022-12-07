<?php

require 'connect.php';

session_start();

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: ./index.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
} else {
    $shoe_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM shoe WHERE shoe_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($shoe_id));
    $statement->execute();
    $post = $statement->fetch();

    if (!$post) {
        header("Location: ./index.php");
    }

    if ($post['user_id'] !== $_SESSION['logged_in_user']['user_id'] && $_SESSION['logged_in_user']['admin_access'] === 0) {
        header("Location: ./index.php");
    }


    $query = "SELECT * FROM brand";
    $statement = $db->prepare($query);
    $statement->execute();
    $brands = $statement->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <?php if (isset($_GET['invalid-post'])) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Invalid Post Edit!
            </div>
        <?php endif ?>
        <form action="processpost.php" method="post" enctype="multipart/form-data" class="mt-3 mb-3">
            <input type="hidden" name="id" value="<?= $shoe_id ?>" />
            <div class="mb-3">
                <label for="description" class="form-label">Shoe Name</label>
                <input class="form-control" type="text" name="name" id="name" value="<?= $post['shoe_name'] ?>" required="required">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required="required"><?= $post['shoe_description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                $<input class="form-control" type="number" name="price" id="price" value="<?= $post['shoe_price'] ?>" required="required">
            </div>

            <div class="mb-3">
                <?php if (!is_null($post['shoe_img_path'])) : ?>
                    <div class="mb-2">
                        <input class="form-check-input" type="checkbox" name="no-image" id="no-image" value="Yes">
                        <label for="no-image" class="form-check-label">Remove Image</label>
                    </div>
                <?php endif ?>
                <div class="mb-2">
                    <label for='image' class="form-label">New Sneaker Image</label>
                    <input class="form-control" type='file' name='image' id='image'>
                </div>
                <div>
                    <p>Current Image</p>
                    <?php if (is_null($post['shoe_img_path'])) : ?>
                        <input type="hidden" name="current_path" value="none" />
                        <b>No Image Found</b>
                    <?php else : ?>
                        <input type="hidden" name="current_path" value="<?= $post['shoe_img_path'] ?>" />
                        <img style="width: 20rem;" height="200" src="<?= $post['shoe_img_path'] ?>" alt="Shoe Image">
                    <?php endif ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="releaseDate" class="form-label">Release Date</label>
                <input class="form-control" type="date" name="releaseDate" id="releaseDate" value="<?= $post['shoe_drop_date'] ?>" required="required">
            </div>

            <div class="mb-3">
                <label for="brands" class="form-label">Shoe Brand: </label>
                <select class="form-control" name="brands" id="brands" required="required">
                    <?php foreach ($brands as $brand) : ?>
                        <?php if ($brand['brand_id'] === $post['brand_id']) : ?>
                            <option value="<?= $brand['brand_id'] ?>" selected><?= $brand['brand_name'] ?></option>
                        <?php else : ?>
                            <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" name="command" value="Update" class="btn btn-primary">Update</button>
            <button type="submit" name="command" value="Delete" class="btn btn-danger">Delete</button>
            <a class="btn btn-light" role="button" href="index.php">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>