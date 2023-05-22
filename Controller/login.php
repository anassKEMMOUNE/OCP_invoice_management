<?php

// Include the User class
require_once '../Model/user.php';
require_once '../Model/dbConfig.php';
$userID;
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
  $password = sanitize($_POST['pass']);

  // Retrieve the user from the database
  $user = User::getByUsername($username,$conn);
  
  if ($user && $user->getPassword() === $password) {
    // Successful login
     session_start();
      $_SESSION['user_id'] = $username;
      $user->useTable();
    $GLOBALS['username'] = $username;
    setcookie('username', $username, time()+36000000, '/');
   header("Location: ../View/database.php?userID=$username");
   


}
}
?>