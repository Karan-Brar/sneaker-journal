<?php
require '.\ImageResize.php';
require '.\ImageResizeException.php';
use \Gumlet\ImageResize;

if (!isset($_POST['command'])) 
{
    header("Location: ./index.php");
    exit;
} else 
{
    $command = trim(filter_input(INPUT_POST, 'command', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    require 'connect.php';
    require 'fileProcessing.php';

    if ($command === "Create") 
    {
        if (!isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) || !isset($_POST['releaseDate']) || !isset($_POST['brands'])) {
            header("Location: ./newpost.php?invalid-post=true");
            exit;
        } 
        else 
        {       
            $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

            if ($image_upload_detected) {
                $image_filename        = $_FILES['image']['name'];
                $temporary_image_path  = $_FILES['image']['tmp_name'];
                $new_image_path        = file_upload_path($image_filename);
                if (file_is_valid($temporary_image_path, $new_image_path)) {
                    $img_path = join(DIRECTORY_SEPARATOR, ['uploads', $image_filename]);

                    $resized_img = new ImageResize($temporary_image_path);
                    $resized_img->resizeToWidth(400);
                    $resized_img->save($img_path);
                    $shoe_img_path = $img_path;
                }
                else
                {
                    header("Location: ./newpost.php?invalid-post=true");
                    exit;
                }
            } else
            {
                $shoe_img_path = null;
            }
        



            session_start();
            $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $price = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $releaseDate = trim(filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $chosenBrand = trim(filter_input(INPUT_POST, 'brands', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $user_id = $_SESSION['logged_in_user']['user_id'];

            if (strlen($name) < 1 || strlen($description) < 1 || !filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT)) {
                header("Location: ./newpost.php?invalid-post=true");
                exit;
            } else 
            {
                $query = "INSERT INTO shoe (shoe_name, shoe_description, shoe_drop_date, shoe_price, shoe_img_path, brand_id, user_id) VALUES (:shoe_name, :shoe_description, :shoe_drop_date, :shoe_price, :shoe_img_path, :brand_id, :user_id)";
                $statement = $db->prepare($query);
                $statement->bindValue(':shoe_name', $name);
                $statement->bindValue(':shoe_description', $description);
                $statement->bindValue(':shoe_drop_date', $releaseDate);
                $statement->bindValue(':shoe_price', $price, PDO::PARAM_INT);
                $statement->bindValue(':shoe_img_path', $shoe_img_path);
                $statement->bindValue(':brand_id', $chosenBrand, PDO::PARAM_INT);
                $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

                $statement->execute();

                header("Location: ./index.php");
                exit;
            }
        }
    } 
    elseif ($command === "Update") 
    {
        if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) || !isset($_POST['releaseDate']) || !isset($_POST['brands'])) {
            header("Location: ./editpost.php?id={$_POST['id']}&invalid-post=true");
            exit;
        } else {
            $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

                if (isset($_POST['no-image'])) {
                    if($_POST['no-image'] === "Yes")
                    {
                        $shoe_img_path = null;
                    }                    
                } else {
                    if ($image_upload_detected) {
                        $image_filename        = $_FILES['image']['name'];
                        $temporary_image_path  = $_FILES['image']['tmp_name'];
                        $new_image_path        = file_upload_path($image_filename);
                        if (file_is_valid($temporary_image_path, $new_image_path)) {
                            $img_path = join(DIRECTORY_SEPARATOR, ['uploads', $image_filename]);

                            $resized_img = new ImageResize($temporary_image_path);
                            $resized_img->resizeToWidth(400);
                            $resized_img->save($img_path);
                            $shoe_img_path = $img_path;
                        } else {
                            header("Location: ./editpost.php?id={$_POST['id']}&invalid-post=true");
                            exit;
                        }
                    }
                    else
                    {
                        $current_path = trim(filter_input(INPUT_POST, 'current_path', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                        if($current_path === "none")
                        {
                            $shoe_img_path = null;
                        }
                        else
                        {
                            $shoe_img_path = $current_path;
                        }
                    }
                }

            $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $price = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $releaseDate = trim(filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $chosenBrand = trim(filter_input(INPUT_POST, 'brands', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            if (strlen($name) < 1 || strlen($description) < 1 || !filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT)) {
                header("Location: ./editpost.php?id={$_POST['id']}&invalid-post=true");
                exit;
            } else {
                $query = "UPDATE shoe SET shoe_name = :shoe_name, shoe_description = :shoe_description, shoe_drop_date = :shoe_drop_date, shoe_price = :shoe_price, shoe_img_path = :shoe_img_path, brand_id = :brand_id WHERE shoe_id = :shoe_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':shoe_name', $name);
                $statement->bindValue(':shoe_description', $description);
                $statement->bindValue(':shoe_drop_date', $releaseDate);
                $statement->bindValue(':shoe_price', $price, PDO::PARAM_INT);
                $statement->bindValue(':shoe_img_path', $shoe_img_path);
                $statement->bindValue(':brand_id', $chosenBrand, PDO::PARAM_INT);
                $statement->bindValue(':shoe_id', $id);
                $statement->execute();

                header("Location: ./index.php");
                exit;
            }
        }
    }
    elseif ($command === "Delete") 
    {
        if (!isset($_POST['id'])) {
            header("Location: ./index.php");;
            exit;
        } else {
            $id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM shoe WHERE shoe_id = :shoe_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':shoe_id', $id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: ./index.php");
            exit;
        }
    }
}


?>

