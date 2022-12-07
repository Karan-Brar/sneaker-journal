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
    <div>
        <h2><?= $post['shoe_name'] ?></h2>
        <?php if (!is_null($post['shoe_img_path'])) : ?>
            <img src="<?= $post['shoe_img_path'] ?>" alt="Shoe Image" width="300" height="200">
        <?php endif ?>
        <?php
        $posting_timestamp = $post['shoe_posting_date'];
        $posting_date = new DateTime($posting_timestamp);
        $posting_date = $posting_date->format('Y-m-d');

        $update_timestamp = $post['shoe_update_date'];
        $update_date = new DateTime($update_timestamp);
        $update_date = $update_date->format('Y-m-d');
        ?>
        <p>Posting By - <?= $username['username'] ?></p>
        <p>Posted on - <?= $posting_date ?></p>
        <p>Last Updated - <?= $update_date ?></p>
        <div>
            <span>Price - $<?= $post['shoe_price'] ?></span>
            <span>Manufacturer - <?= $brandname['brand_name'] ?></span>
        </div>
        <h4><?= $post['shoe_description'] ?></h4>
    </div>

    <div>
        <h2>Comments</h2>
        <?php if (isset($_SESSION['logged_in_user'])) : ?>
            <div>
                <?php if (isset($_GET['invalid-comment'])) : ?>
                    <h2>Invalid Comment!</h2>
                <?php endif ?>
                <form action="processcomment.php" method="post">
                    <input type="hidden" name="shoe_id" value="<?= $post['shoe_id'] ?>">
                    <div>
                        <label for="comment">Post a Comment</label>
                        <textarea name="comment" id="description" cols="30" rows="10" required="required"></textarea>
                        <input type="submit" name="command" value="Create" id="createBtn">
                    </div>
                </form>
            </div>
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
                    <div>
                        <form action="processcomment.php" method="post">
                            <h4><?= $comment_user['username'] ?></h4>
                            <h4><?= $comment_date ?></h4>
                            <p><?= $comment['comment_text'] ?></p>
                            <?php if ($comment['user_id'] === $_SESSION['logged_in_user']['user_id'] || $_SESSION['logged_in_user']['admin_access'] === 1) : ?>
                                <a href="editcomment.php?id=<?= $comment['comment_id'] ?>">Edit Comment</a>
                            <?php endif ?>
                        </form>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php else : ?>
            <h3>You need to login to view or post comments!</h3>
        <?php endif ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>