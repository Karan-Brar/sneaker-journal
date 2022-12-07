<?php

if (!isset($_POST['command'])) {
    header("Location: ./index.php");
    
} else {
    $command = trim(filter_input(INPUT_POST, 'command', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    require 'connect.php';

    if ($command === "Create") {
        if (!isset($_POST['name'])) {
            header("Location: ./newbrand.php?invalid-brand=true");
            
        } else {
            $brand_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            if (strlen($brand_name) < 1) {
                header("Location: ./newbrand.php?invalid-brand=true");
                
            } else {
                $query = "INSERT INTO brand (brand_name) VALUES (:name)";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $brand_name);

                $statement->execute();

                header("Location: ./brands.php");
                
            }
        }
    } elseif ($command === "Update") {
        if (!isset($_POST['name'])) {
            header("Location: ./editbrand.php?id={$_POST['id']}&invalid-brand=true");
             
        } else {
            $brand_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $brand_id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            if (strlen($brand_name) < 1) 
            {
                header("Location: ./editbrand.php?id={$_POST['id']}&invalid-brand=true");
            } 
            else 
            {
                $query = "UPDATE brand SET brand_name = :name  WHERE brand_id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $brand_name);
                $statement->bindValue(':id', $brand_id);
                $statement->execute();

                header("Location: ./brands.php");
            }
        }
    } elseif ($command === "Delete") {
            $id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM brand WHERE brand_id = :brand_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':brand_id', $id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: ./brands.php");
    }
}

?>