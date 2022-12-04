<?php

require 'connect.php';

session_start();

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: ./index.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
    exit;
} else {
    $shoe_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM shoe WHERE shoe_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($shoe_id));
    $statement->execute();
    $post = $statement->fetch();

    if (!$post) {
        header("Location: ./index.php");
        exit;
    }

    if ($post['user_id'] !== $_SESSION['logged_in_user']['user_id'] && $_SESSION['logged_in_user']['admin_access'] === 0) {
        header("Location: ./index.php");
        exit;
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
    <title>IceFeet - </title>
</head>

<body>
    <form action="processpost.php" method="post" id="editPost" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $shoe_id ?>" />
        <div>
            <label for="description">Shoe Name: </label>
            <input type="text" name="name" id="name" value="<?= $post['shoe_name'] ?>" required="required">
        </div>

        <div>
            <label for="description">Description: </label>
            <textarea name="description" id="description" cols="30" rows="10" required="required"><?= $post['shoe_description'] ?></textarea>
        </div>

        <div>
            <label for="price">Price: </label>
            $<input type="number" name="price" id="price" value="<?= $post['shoe_price'] ?>" required="required">
        </div>

        <div>
            <?php if (!is_null($post['shoe_img_path'])) : ?>
                <label for="no-image">Remove Image: </label>
                <input type="checkbox" name="no-image" id="no-image" value="Yes">
            <?php endif ?>

            <label for='image'>New Sneaker Image: </label>
            <input type='file' name='image' id='image'>
            <p>Current Image: </p>
            <?php if (is_null($post['shoe_img_path'])) : ?>
                <input type="hidden" name="current_path" value="none" />
                <b>No Image Found</b>
            <?php else : ?>
                <input type="hidden" name="current_path" value="<?= $post['shoe_img_path'] ?>" />
                <img src="<?= $post['shoe_img_path'] ?>" alt="Shoe Image" width="300" height="200">
            <?php endif ?>
        </div>

        <div>
            <label for="releaseDate">Release Date: </label>
            <input type="date" name="releaseDate" id="releaseDate" value="<?= $post['shoe_drop_date'] ?>" required="required">
        </div>

        <div>
            <label for="brands">Shoe Brand: </label>
            <select name="brands" id="brands" required="required">
                <?php foreach ($brands as $brand) : ?>
                    <?php if ($brand['brand_id'] === $post['brand_id']) : ?>
                        <option value="<?= $brand['brand_id'] ?>" selected><?= $brand['brand_name'] ?></option>
                    <?php else : ?>
                        <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
        <input type="submit" name="command" value="Update" id="updateBtn">
        <input type="submit" name="command" value="Delete" id="deleteBtn">
        <a href="index.php">Cancel</a>
    </form>
</body>

</html>