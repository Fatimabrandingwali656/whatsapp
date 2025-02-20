<?php
// config.php
session_start();

$servername = "localhost";
$username = "ubicsbhlhfvcc";
$password = "ql4zg1kyj9kp";
$dbname = "dbpgksdmrdurep";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
