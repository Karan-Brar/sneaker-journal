<?php

if (!isset($_POST['command'])) {
    header("Location: ./index.php");
    
}
else
{
    $command = trim(filter_input(INPUT_POST, 'command', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    require 'connect.php';

    if ($command === "Create") {
        if (!isset($_POST['comment'])) {
            header("Location: ./fullpost.php?id={$_POST['shoe_id']}&invalid-comment=true");
            
        } else {
            session_start();

            $comment = trim(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $shoeId = filter_input(INPUT_POST, 'shoe_id', FILTER_SANITIZE_NUMBER_INT);
            $userId = $_SESSION['logged_in_user']['user_id'];

            if (strlen($comment) < 1) {
                header("Location: ./fullpost.php?id={$_POST['shoe_id']}&invalid-comment=true");
                
            } else {
                $query = "INSERT INTO comment (comment_text, user_id, shoe_id) VALUES (:comment_text, :user_id, :shoe_id)";
                $statement = $db->prepare($query);
                $statement->bindValue(':comment_text', $comment);
                $statement->bindValue(':shoe_id', $shoeId, PDO::PARAM_INT);
                $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

                $statement->execute();

                header("Location: ./fullpost.php?id={$_POST['shoe_id']}");
                
            }
        }
    } 
    elseif ($command === "Edit") 
    {
        if (!isset($_POST['text'])) {
            header("Location: ./editcomment.php?id={$_POST['id']}&invalid-comment=true");
            
        } else {
            $comment_text = trim(filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $comment_id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $shoe_id  = filter_input(INPUT_POST, 'shoe_id', FILTER_SANITIZE_NUMBER_INT);

            if (strlen($comment_text) < 1) {
                header("Location: ./editcomment.php?id={$_POST['id']}&invalid-comment=true");
                
            } else {
                $query = "UPDATE comment SET comment_text = :comment_text  WHERE comment_id = :comment_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':comment_text', $comment_text);
                $statement->bindValue(':comment_id', $comment_id);
                $statement->execute();

                header("Location: ./fullpost.php?id={$shoe_id}");
                
            }
        }
    } 
    elseif ($command === "Delete") 
    {
            $comment_id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $shoe_id  = filter_input(INPUT_POST, 'shoe_id', FILTER_SANITIZE_NUMBER_INT);


            $query = "UPDATE comment SET visible_comment = 0  WHERE comment_id = :comment_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':comment_id', $comment_id);
            $statement->execute();

            header("Location: ./fullpost.php?id={$shoe_id}");           
    }
}

?>