<?php


if (!isset($_POST['command'])) {
    header("Location: ./register.php?invalid-user=true");
    
} else {
    $command = trim(filter_input(INPUT_POST, 'command', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    require 'connect.php';

    if ($command === "Register") {
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $repass = trim(filter_input(INPUT_POST, 'repass', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (strlen($username) < 1 || strlen($pass) < 1 || strlen($repass) < 1) {
            header("Location: ./register.php?invalid-user=true");
            
        } elseif ($pass !== $repass) {
            header("Location: ./register.php?invalid-user=true");
            
        } else {
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $hashed_pass);

            $statement->execute();

            session_start();

            if (isset($_SESSION['logged_in_user'])) {
                if (!($_SESSION['logged_in_user']['admin_access'] === 1)) {
                    header("Location: ./users.php");
                }
            }

            header("Location: ./login.php");
            
        }
    }
    else if($command === "Update")
    {
        if (!isset($_POST['name'])) {
            header("Location: ./edituser.php?id={$_POST['id']}&invalid-user=true");
        } else {
            $username = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $admin_access = 0;
            
            if(isset($_POST['admin-access']))
            { 
                if($_POST['admin-access'] === "Yes")
                {
                    $admin_access = 1;
                }
            }

            if (strlen($username) < 1) {
                header("Location: ./edituser.php?id={$_POST['id']}&invalid-user=true");
            } else {
                $query = "UPDATE user SET username = :username, admin_access = :admin_access  WHERE user_id = :user_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':admin_access', $admin_access, PDO::PARAM_INT );
                $statement->bindValue(':user_id', $id);
                $statement->execute();

                header("Location: ./users.php?admin-access={$admin_access}");
                exit;                 
            }
        }
    } elseif ($command === "Delete") {

            $id  = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM user WHERE user_id = :user_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: ./users.php");
    }
}

?>
