<?php

/*
This PHP script contains code to establish connection with the the server-side database.
*/

define('DB_DSN', 'mysql:host=localhost;port=3306;dbname=shoe_journal;charset=utf8');
define('DB_USER','serveruser');
define('DB_PASS','gorgonzola7!');

$db = new PDO(DB_DSN, DB_USER, DB_PASS);

?>