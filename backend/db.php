<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "task_db";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Could not connect: " . mysqli_connect_error());
}


?>
