<?php

require 'connect.php';

session_start();

if (isset($_SESSION['logged_in_user'])) {
    if (!($_SESSION['logged_in_user']['admin_access'] === 1)) {
        header("Location: ./index.php");
    }
} else {
    header("Location: ./index.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
} else {
    $brand_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM brand WHERE brand_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($brand_id));
    $statement->execute();
    $post = $statement->fetch();

    if (!$post) {
        header("Location: ./brands.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Edit Brand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <?php if (isset($_GET['invalid-brand'])) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Invalid Edit Made!
            </div>
        <?php endif ?>
        <form action="processbrand.php" method="post" class="mt-3">
            <input type="hidden" name="id" value="<?= $brand_id ?>" />
            <div>
                <label for="name" class="form-label">Brand Name</label>
                <input type=" text" name="name" id="name" value="<?= $post['brand_name'] ?>" class="form-control">
            </div>
            <div class="mt-3">
                <button type="submit" name="command" value="Update" class="btn btn-primary">Update</button>
                <button type="submit" name="command" value="Delete" class="btn btn-danger">Delete</button>
                <a class="btn btn-light" href="brands.php" role="button">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>