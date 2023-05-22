<?php

class User {
  private $username;
  private $email;
  private $password;
  
  // Constructor
  public function __construct($username, $email, $password) {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
  }
  
  // Getters
//   public function getUserID(){
//     return $this->userID;
//   }
  public function getUsername() {
    return $this->username;
  }
  
  public function getEmail() {
    return $this->email;
  }
  
  public function getPassword() {
    return $this->password;
  }
  
  public function save() {
    require 'dbConfig.php';
    
    // Check if user already exists
    $existingUser = $this->getByUsername($this->username, $conn);
    // if ($existingUser) {
    //   echo "User already exists.";
    //   return;
    // }
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $this->username, $this->email, $this->password);
    
    // if ($stmt->execute()) {
    //   $stmt->close();
      
    //   // Fetch the last inserted ID
    //   $result = $conn->query("SELECT max(userID) FROM users");
    //   $row = $result->fetch_row();
    //   $lastInsertId = $row[0];
      
    //   $this->userID = $lastInsertId; // Store the last inserted ID in the userId property
    //   echo "User saved successfully. UserID: " . $this->userID;
    // } else {
    //   echo "Error: " . $stmt->error;
    // }
    $stmt->execute();
    $conn->close();
  }
  
  
  
// Retrieve a user from the database by username
public static function getByUsername($username, $conn) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    
    if (!$stmt) {
      echo "Error: " . $conn->error;
      return null;
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
  
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
  
    $stmt->close();
  
    if ($user) {
      return new User($user['username'], $user['email'], $user['password']);
    }
  
    return null;
  }
  
  
  
  // Update the user's email in the database
  public function updateEmail($newEmail) {
    require 'dbConfig.php';    
    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
    $stmt->bind_param("ss", $newEmail, $this->username);
    
    if ($stmt->execute()) {
      echo "Email updated successfully.";
      $this->email = $newEmail;
    } else {
      echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
  }
  
  // Delete the user from the database
  public function delete() {
    require 'dbConfig.php';    

    
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $this->username);
    
    if ($stmt->execute()) {
      echo "User deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
      }
      
      $stmt->close();
      $conn->close();
    }
public function createDB(){
    require 'dbConfig.php';    
    
    $user_database = "user_database_" . $this->username;
    $dropIF =  "Drop database if exists $user_database";
    $grant_privileges = "GRANT ALL PRIVILEGES ON " . $user_database . ".* TO '" . $this->username . "'@'localhost'";
    $use_database = "USE " . $user_database;
    $conn->query($dropIF);
    // Create the user's database
    if ($conn->query("CREATE DATABASE " . $user_database) === TRUE) {
        echo "user db created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
        return;
    }
    
    // Grant privileges to the user
    $conn->query($grant_privileges);
    $conn->query($use_database);
    $conn->close();
}
public function createTables(){
    require 'dbConfigUser.php';
    $this->useTable();
    $conn = connectToUserDatabase($this->username);

    // Read the SQL commands from the file
    $sqlCommands = file_get_contents('createTables-ddl.sql');

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
}

public function useTable(){
    require 'dbConfig.php';    
    $user_database = "user_database_" . $this->username;
    $use_database = "USE " . $user_database;

    // Switch to the user's database
    $conn->query($use_database);

    $conn->close();
}
}