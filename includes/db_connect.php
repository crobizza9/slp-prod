<?php

$servername = "db";
$dbuser     = "slpdev";
$dbpass     = "devplayground";
$dbname     = "slp_db_dev";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
// Use utf8mb4
$conn->set_charset("utf8mb4");
