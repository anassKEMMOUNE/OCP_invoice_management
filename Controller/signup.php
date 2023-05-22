<?php
require_once "../Model/user.php";
// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    setcookie('username', $username, time()+360000, '/');
    // Create a new User object
    $user = new User($username, $email, $password);
  
    // Save the user
    $user->save();
    $user->createDB();
    $user -> useTable();
    require '../Model/dbConfigUser.php';
    $conn = connectToUserDatabase($username);

    // Read the SQL commands from the file
    $sqlCommands = file_get_contents('../Model/createTables-ddl.sql');

    // Execute the SQL commands
    if ($conn->multi_query($sqlCommands)) {
        do {
            // Check if there are more results
            if ($result = $conn->store_result()) {
                // Free the result set
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    } else {
        echo "Error executing SQL commands: " . $conn->error;
    }

    // Close the MySQL connection
    $conn->close();
    session_start();
    $_SESSION['user_id'] = $_POST['username'];
    $GLOBALS['username'] = $username;
    // Redirect to success page or perform any other actions
    header("Location: ../View/database.php?userID=$username");
    exit();
  }

?>