<?php

require 'connect.php';

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
} else {
    $brand_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM shoe WHERE brand_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($brand_id));
    $statement->execute();
    $posts = $statement->fetchAll();

    if (!$posts) {
        header("Location: ./index.php?nopostings=true");
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
    <title>IceFeet - Brand Shoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <div class="dropdown mb-2 mt-2">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Navigate by Brand</a>
            <ul class="dropdown-menu">
                <?php foreach ($brands as $brand) : ?>
                    <li><a class="dropdown-item" href="brandposts.php?id=<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="container text-center">
            <div class="row">
                <?php foreach ($posts as $shoe) : ?>
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