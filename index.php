<?php

require 'connect.php';

$sorting = "none";

if (isset($_GET['sort'])) {
    $sorting = $_GET['sort'];
}

if ($sorting === "none") {
    $query = "SELECT * FROM shoe ORDER BY shoe_posting_date DESC";
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
    $query = "SELECT * FROM shoe ORDER BY shoe_posting_date DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
} else if ($sorting === "post_dateDESC") {
    $query = "SELECT * FROM shoe ORDER BY shoe_posting_date ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    $shoe_posts = $statement->fetchAll();
}


if (isset($_GET['searchrequest'])) {
    if (!isset($_POST['search-value'])) {
        header("Location: ./index.php");
    }

    $search_value = trim(filter_input(INPUT_POST, 'search-value', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if (strlen($search_value) < 1) {
        header("Location: ./index.php");
    } else {
        $query = "SELECT * FROM Shoe WHERE shoe_name LIKE CONCAT('%', :search_value, '%')";
        $statement = $db->prepare($query);
        $statement->bindValue(':search_value', $search_value);
        $statement->execute();
        $shoe_posts = $statement->fetchAll();
    }
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
    <title>IceFeet - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <form class="mt-3" action="index.php?searchrequest=true" method="post">
            <input class="form-control" type="text" name="search-value" id="search" placeholder="Search For Shoes.." style="width:20rem;">
            <button type="submit" class="btn btn-primary mt-2" value="Search">Search</button>
        </form>
        <div class="dropdown mb-3 mt-3">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Navigate by Brand</a>
            <ul class="dropdown-menu">
                <?php foreach ($brands as $brand) : ?>
                    <li><a class="dropdown-item" href="brandposts.php?id=<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php if (!isset($_GET['searchrequest'])) : ?>
            <div class="mt-3 mb-3">
                <h5>Sorting By
                    <?php if (isset($_GET['sort'])) : ?>
                        <?php if ($_GET['sort'] === "nameASC") : ?>
                            <span class="badge bg-secondary">Name(A-Z)</span>
                        <?php elseif ($_GET['sort'] === "nameDESC") : ?>
                            <span class="badge bg-secondary">Name(Z-A)</span>
                        <?php elseif ($_GET['sort'] === "priceASC") : ?>
                            <span class="badge bg-secondary">Price(Low to High)</span>
                        <?php elseif ($_GET['sort'] === "priceDESC") : ?>
                            <span class="badge bg-secondary">Price(High to Low)</span>
                        <?php elseif ($_GET['sort'] === "post_dateASC") : ?>
                            <span class="badge bg-secondary">Posting Date(New to Old)</span>
                        <?php elseif ($_GET['sort'] === "post_dateDESC") : ?>
                            <span class="badge bg-secondary">Posting Date(Old to New)</span>
                        <?php endif ?>
                    <?php else : ?>
                        <span class="badge bg-secondary">No Sorting applied</span>
                    <?php endif ?>
                </h5>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort By
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?sort=nameASC">Name(A-Z)</a></li>
                        <li><a class="dropdown-item" href="index.php?sort=nameDESC">Name(Z-A)</a></li>
                        <li><a class="dropdown-item" href="index.php?sort=priceASC">Price(Low to High)</a></li>
                        <li><a class="dropdown-item" href="index.php?sort=priceDESC">Price(High to Low)</a></li>
                        <li><a class="dropdown-item" href="index.php?sort=post_dateASC">Posting Date(New to Old)</a></li>
                        <li><a class="dropdown-item" href="index.php?sort=post_dateDESC">Posting Date(Old to New)</a></li>
                        <li><a class="dropdown-item" href="index.php">No Sort</a></li>
                    </ul>
                </div>
            </div>
        <?php endif ?>
        <?php if (isset($_GET['not_logged_in'])) : ?>
            <div class="alert alert-danger" role="alert">
                Please Login to create a new post!
            </div>
        <?php else : ?>
            <a class="btn btn-primary" href="newpost.php" role="button">New Shoe Posting</a>
        <?php endif ?>
        <div class=" container text-center">
            <div class="row">
                <?php foreach ($shoe_posts as $shoe) : ?>
                    <div class="col-4">
                        <div class="card mb-4 mt-2" style="width: 24rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $shoe['shoe_name'] ?></h5>
                                <?php if (!is_null($shoe['shoe_img_path'])) : ?>
                                    <img src="<?= $shoe['shoe_img_path'] ?>" alt="Shoe Image" class="card-img" style="width: 20rem;" height="200">
                                <?php else : ?>
                                    <img src="./uploads/No_image_available.png" alt="Shoe Image" class="card-img" style="width: 14rem;" height="180">
                                <?php endif ?>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Price - $<?= $shoe['shoe_price'] ?></li>
                                    <li class="list-group-item">Posted on - <?= $shoe['shoe_posting_date'] ?></li>
                                </ul>
                                <?php if (isset($_SESSION['logged_in_user'])) : ?>
                                    <?php if ($_SESSION['logged_in_user']['user_id'] === $shoe['user_id'] || $_SESSION['logged_in_user']['admin_access'] === 1) : ?>
                                        <a href="editpost.php?id=<?= $shoe['shoe_id'] ?>" class="btn btn-primary">Edit Post</a>
                                    <?php endif ?>
                                <?php endif ?>
                                <a href="fullpost.php?id=<?= $shoe['shoe_id'] ?>" class="btn btn-primary">View Full Post</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>