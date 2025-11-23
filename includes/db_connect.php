<?php

$servername = "";
$dbuser     = "";
$dbpass     = "";
$dbname     = "";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
// Use utf8mb4
$conn->set_charset("utf8mb4");
