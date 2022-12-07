<?php

require 'connect.php';

session_start();

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: ./index.php");
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
} else {
    $comment_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM comment WHERE comment_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($comment_id));
    $statement->execute();
    $comment = $statement->fetch();

    if (!$comment) {
        header("Location: ./index.php");
    }

    if ($comment['user_id'] !== $_SESSION['logged_in_user']['user_id'] && $_SESSION['logged_in_user']['admin_access'] === 0) {
        header("Location: ./index.php");
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
    <title>IceFeet - Edit Comment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <?php if (isset($_GET['invalid-comment'])) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Invalid Comment Edit!
            </div>
        <?php endif ?>
        <form action="processcomment.php" method="post" class="mt-3">
            <input type="hidden" name="id" value="<?= $comment_id ?>" />
            <input type="hidden" name="shoe_id" value="<?= $comment['shoe_id'] ?>" />
            <div class="mb-3">
                <label for="text" class="form-label">Comment Text</label>
                <input type="text" name="text" id="text" value="<?= $comment['comment_text'] ?>" class="form-control">
            </div>
            <button type="submit" name="command" value="Edit" class="btn btn-primary">Update</button>
            <button type="submit" name="command" value="Delete" class="btn btn-danger">Delete</button>
            <a class="btn btn-light" role="button" href="fullpost.php?id=<?= $comment['shoe_id'] ?>">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>