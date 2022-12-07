<?php

if (!isset($_POST['command'])) {
    header("Location: ./login.php");
    
}
else
{
    require 'connect.php';

    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if (strlen($username) < 1 || strlen($pass) < 1) {
        header("Location: ./login.php?invalid-login=true");
        
    }
    else
    {
        $query = "SELECT * FROM user WHERE username=:username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);

        $statement->execute();
        $user = $statement->fetch();

        if(is_null($user))
        {
            header("Location: ./login.php?invalid-login=true");
            
        }
        else
        {
            if(password_verify($pass, $user['password']))
            {
                session_start();
                $_SESSION['logged_in_user'] = $user;
                header("Location: ./index.php");
                
            }
            else
            {
                header("Location: ./login.php?invalid-login=true");
                
            }
        }
    }
}

?>