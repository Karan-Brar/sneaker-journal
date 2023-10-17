<?php

/*
This PHP script contains code to establish connection with the the server-side database.
*/

define('DB_DSN', 'mysql:host=containers-us-west-57.railway.app;port=7296;dbname=railway;charset=utf8');
define('DB_USER','root');
define('DB_PASS', 'VpZEXlJASdhuCne0RB7T');

$db = new PDO(DB_DSN, DB_USER, DB_PASS);

?>