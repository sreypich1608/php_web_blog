<?php 
// database for admin user

require 'constants.php';
// connect to database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(mysqli_errno($connection)){
    die("database connection failed".mysqli_error($connection));
}