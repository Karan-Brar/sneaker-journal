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
    <title>IceFeet - Brands</title>
</head>

<body>
    <div>
        <a href="newbrand.php">Create New Brand</a>
        <h1>Brand List - </h1>
        <?php foreach ($brands as $brand) : ?>
            <ul>
                <li><?= $brand['brand_name'] ?></li>
                <a href="editbrand.php?id=<?= $brand['brand_id'] ?>">Edit Brand</a>
            </ul>
        <?php endforeach ?>
    </div>
</body>

</html>