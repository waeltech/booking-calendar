<?php




// Make a MySQL Connection for xamp
$host="localhost";
$user="root";
$password="";
$db = "booking2";
$link = mysqli_connect($host, $user, $password);
mysqli_select_db($link, $db) or die(mysql_error());

?>
