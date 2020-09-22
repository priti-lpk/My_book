<?php
if (!defined('SERVER_KEY')) define("SERVER_KEY", "xxxxxxxxxxxxxxxxx");
if (!defined('Authorization')) define('Authorization', 'XXXX');
$db_user = "root";
$db_password = "";
$db_host = "localhost";
$db_name = "my_book";
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$con) {
   echo "can not connect to database" . mysql_error();
   die();
} 
?>