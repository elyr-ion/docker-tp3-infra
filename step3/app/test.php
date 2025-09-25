<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "data";
$username = "root";
$password = "password";
$dbname = "testdb";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Write a random value
$val = rand(1, 100);
$conn->query("INSERT INTO test_table (value) VALUES ($val)");

// Read last inserted value
$result = $conn->query("SELECT * FROM test_table ORDER BY id DESC LIMIT 1");
$row = $result->fetch_assoc();

echo "Last inserted value: " . $row['value'];

$conn->close();
