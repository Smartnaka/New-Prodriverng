<?php

require_once 'config.php';

$host = "localhost";
$user = "root";
$password = ""; 
$database = "prodrivers";//db name

$conn = new mysqli($host, $user, $password, $database);


//Check connection
if ($conn->connect_error) {
     die("connection failed: " .
     $conn->connect_error);
}
 
?>