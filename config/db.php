<?php
// config/db.php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "dynamic_form_builder";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset (important for safety)
$conn->set_charset("utf8");
