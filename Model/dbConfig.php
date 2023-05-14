<?php
// MySQL connection configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'invoiceDb';



// Create a MySQL connection
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>