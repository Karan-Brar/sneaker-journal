<?php

require 'connect.php';


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

    $query = "SELECT u.username FROM shoe s JOIN user u ON s.user_id=u.user_id WHERE shoe_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($shoe_id));
    $statement->execute();
    $username = $statement->fetch();

    $query = "SELECT b.brand_name FROM shoe s JOIN brand b ON s.brand_id=b.brand_id WHERE shoe_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($shoe_id));
    $statement->execute();
    $brandname = $statement->fetch();

    $query = "SELECT * FROM comment s WHERE shoe_id=:id ORDER BY comment_publish_date DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($shoe_id));
    $statement->execute();
    $comments = $statement->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['shoe_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <div class="col d-flex justify-content-center">
            <div class="card text-center mt-5" style="width: 30rem;">
                <?php if (!is_null($post['shoe_img_path'])) : ?>
                    <img class="card-img-top" src=" <?= $post['shoe_img_path'] ?>" alt="Shoe Image">
                <?php else : ?>
                    <img class="card-img-top" src=" ./uploads/No_image_available.png" alt="Shoe Image" class="card-img" style="width: 14rem;" height="180">
                <?php endif ?>
                <?php
                $posting_timestamp = $post['shoe_posting_date'];
                $posting_date = new DateTime($posting_timestamp);
                $posting_date = $posting_date->format('Y-m-d');

                $update_timestamp = $post['shoe_update_date'];
                $update_date = new DateTime($update_timestamp);
                $update_date = $update_date->format('Y-m-d');
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?= $post['shoe_name'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Posting By <?= $username['username'] ?></h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Posted on <?= $posting_date ?></li>
                        <li class="list-group-item">Last Updated on <?= $update_date ?></li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">Priced at $<?= $post['shoe_price'] ?></li>
                        <li class="list-inline-item">Manufactured by <?= $brandname['brand_name'] ?></li>
                    </ul>
                    <blockquote class="blockquote">
                        <p><?= $post['shoe_description'] ?></p>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="mt-4" style="width: 30rem; margin:auto">
            <h2>Comments</h2>
            <?php if (isset($_SESSION['logged_in_user'])) : ?>
                <?php if (isset($_GET['invalid-comment'])) : ?>
                    <div class=" alert alert-danger mt-3" role="alert">
                        Invalid Comment!
                    </div>
                <?php endif ?>
                <form action="processcomment.php" method="post" class="mb-4">
                    <input type="hidden" name="shoe_id" value="<?= $post['shoe_id'] ?>">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Post a Comment</label>
                        <textarea name="comment" id="description" class="form-control" rows="3" required="required"></textarea>
                    </div>
                    <button type="submit" name="command" value="Create" class="btn btn-primary">Comment</button>
                </form>
                <?php foreach ($comments as $comment) : ?>
                    <?php if ($comment['visible_comment'] === 1) : ?>
                        <?php
                        $query = "SELECT u.username FROM comment c JOIN user u ON c.user_id=u.user_id WHERE     comment_id=:id";
                        $statement = $db->prepare($query);
                        $statement->bindValue(':id', intval($comment['comment_id']));
                        $statement->execute();
                        $comment_user = $statement->fetch();

                        $comment_timestamp = $comment['comment_publish_date'];
                        $comment_date = new DateTime($comment_timestamp);
                        $comment_date = $comment_date->format('h:i A Y-m-d');
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= $comment_user['username'] ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $comment_date ?></h6>
                                <p class="card-text"><?= $comment['comment_text'] ?></p>
                                <?php if ($comment['user_id'] === $_SESSION['logged_in_user']['user_id'] || $_SESSION['logged_in_user']['admin_access'] === 1) : ?>
                                    <a href="editcomment.php?id=<?= $comment['comment_id'] ?>" class="btn btn-secondary">Edit Comment</a>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            <?php else : ?>
                <div class=" alert alert-warning" role="alert">
                    Please Login to View or Post Comments!
                </div>
            <?php endif ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>