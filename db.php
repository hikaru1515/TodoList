<?php
$host = "localhost";
$userName = "root";
$password = "";
$dbname = "todo_app";

$conn = new mysqli($host, $userName, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname;";
if(!mysqli_query($conn, $sql)){
    die("");
    $conn->close();
}

$conn->select_db($dbname);

//create Table
$sql = "CREATE TABLE  IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
);";

if(!mysqli_query($conn, $sql)){
    die("");
}
