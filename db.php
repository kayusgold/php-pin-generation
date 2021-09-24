<?php

$host = "localhost";
$username = "root";
$passowrd = "";
$database = "pins";

$conn = mysqli_connect($host, $username, $passowrd, $database);

if (!$conn) {
    die("Database Connection Error");
}
