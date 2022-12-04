<?php

require 'connect.php';

$sorting = "none";

if (isset($_GET['sort'])) {
    $sorting = $_GET['sort'];
}

if ($sorting === "none") {
    $query = "SELECT * FROM shoe";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "nameASC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_name ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "nameDESC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_name DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "priceASC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_price ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "priceDESC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_price DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "post_dateASC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_posting_date ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "post_dateDESC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_posting_date DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Home</title>
</head>

<body>
    <div>
        <?php require 'header.php' ?>
        <?php if (isset($_GET['not_logged_in'])) : ?>
            <h4>Please Login to create a new post!</h4>
        <?php endif ?>
        <a href=" newpost.php">New Shoe Posting</a>
        <div>
            <p>Sorting by - </p>
            <?php if (isset($_GET['sort'])) : ?>
                <?php if ($_GET['sort'] === "nameASC") : ?>
                    <b>Name(A-Z)</b>
                <?php elseif ($_GET['sort'] === "nameDESC") : ?>
                    <b>Name(Z-A)</b>
                <?php elseif ($_GET['sort'] === "priceASC") : ?>
                    <b>Price(Low to High)</b>
                <?php elseif ($_GET['sort'] === "priceDESC") : ?>
                    <b>Price(High to Low)</b>
                <?php elseif ($_GET['sort'] === "post_dateASC") : ?>
                    <b>Posting Date(New to Old)</b>
                <?php elseif ($_GET['sort'] === "post_dateDESC") : ?>
                    <b>Posting Date(Old to New)</b>
                <?php endif ?>
            <?php else : ?>
                <b>No Sorting applied</b>
            <?php endif ?>
            <p>Sort by - </p>
            <a href="index.php?sort=nameASC">Name(A-Z)</a>
            <a href="index.php?sort=nameDESC">Name(Z-A)</a>
            <a href="index.php?sort=priceASC">Price(Low to High)</a>
            <a href="index.php?sort=priceDESC">Price(High to Low)</a>
            <a href="index.php?sort=post_dateASC">Posting Date(New to Old)</a>
            <a href="index.php?sort=post_dateDESC">Posting Date(Old to New)</a>
            <a href="index.php">No Sort</a>
            <?php if (isset($_GET['sort'])) : ?>

            <?php endif ?>
        </div>
        <?php foreach ($shoe_posts as $shoe) : ?>
            <div style="margin-bottom: 2px solid black">
                <h2><?= $shoe['shoe_name'] ?></h2>
                <?php if (isset($_SESSION['logged_in_user'])) : ?>
                    <?php if ($_SESSION['logged_in_user']['user_id'] === $shoe['user_id'] || $_SESSION['logged_in_user']['admin_access'] === 1) : ?>
                        <a href="editpost.php?id=<?= $shoe['shoe_id'] ?>">Edit Post</a>
                    <?php endif ?>
                <?php endif ?>
                <a href="fullpost.php?id=<?= $shoe['shoe_id'] ?>">View Full Post</a>
                <?php if (!is_null($shoe['shoe_img_path'])) : ?>
                    <img src="<?= $shoe['shoe_img_path'] ?>" alt="Shoe Image" width="300" height="200">
                <?php endif ?>
                <div>
                    <h5>Release Date - <?= $shoe['shoe_drop_date'] ?></h5>
                    <h5>Price - $<?= $shoe['shoe_price'] ?></h5>
                    <p>Posted on - <?= $shoe['shoe_posting_date'] ?></p>
                    <p>Last Updated on - <?= $shoe['shoe_posting_date'] ?></p>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>