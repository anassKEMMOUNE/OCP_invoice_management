<?php
// Function to establish a MySQL connection based on the userID
if (!function_exists('connectToUserDatabase')) {
function connectToUserDatabase($userID) {
    
    $host = 'localhost';
    $user = 'root';
    $password = '';
    // Set the appropriate database name
    $database = 'user_database_' . $userID;

    // Create a MySQL connection
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        return $conn;
    }

    
}}
?>