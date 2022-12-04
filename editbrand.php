<?php

require 'connect.php';

session_start();

if (isset($_SESSION['logged_in_user']))
{
    if(!($_SESSION['logged_in_user']['admin_access'] === 1))
    {
        header("Location: ./index.php");
    }
}
else
{
    header("Location: ./index.php");
} 

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
    exit;
} else {
    $brand_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM brand WHERE brand_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', intval($brand_id));
    $statement->execute();
    $post = $statement->fetch();

    if (!$post) {
        header("Location: ./brands.php");
        exit;
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
</head>

<body>
    <form action="processbrand.php" method="post" id="editBrand">
        <input type="hidden" name="id" value="<?= $brand_id ?>" />
        <div>
            <label for="name">Brand Name: </label>
            <input type="text" name="name" id="name" value="<?= $post['brand_name'] ?>">
        </div>

        <input type="submit" name="command" value="Update" id="updateBtn">
        <input type="submit" name="command" value="Delete" id="deleteBtn">
        <a href="brands.php">Cancel</a>
    </form>
</body>

</html>