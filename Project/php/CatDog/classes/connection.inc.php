<?php

//HOST
$host		= "classmysql.engr.oregonstate.edu";
$user_name	= "cs340_kokeshs";
$password 	= "9362";
$dbname 	= "cs340_kokeshs";

//Live 
global $conn; 
//CONNECTION
//Database Connection 
$conn = mysqli_connect($host, $user_name, $password , $dbname);
//Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?> 