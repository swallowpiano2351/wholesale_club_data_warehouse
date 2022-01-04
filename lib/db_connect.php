<?php

// building connection to database
$host = "localhost";
$port = "3306";
$username = "root";
$user_pass = "111217";
$database_in_use = "PPDW";

$conn = new mysqli($host, $username, $user_pass, $database_in_use, $port);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}
// echo $conn->host_info . "<br>";

?>