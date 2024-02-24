<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_database";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
$conn->query($sql); // Execute query

// Select the created database
$conn->select_db($database);

// SQL query to create USER table
$sql_user = "CREATE TABLE IF NOT EXISTS USER (
  NAME VARCHAR(255) NOT NULL,
  AADHAAR VARCHAR(12) PRIMARY KEY,
  CARDNO VARCHAR(30) NOT NULL,
  OCCUPATION VARCHAR(30),
  CONTACT INT(10) NOT NULL,
  EMAIL VARCHAR(255),
  ADDRESS TEXT
);";
$conn->query($sql_user); // Execute query

// SQL query to create CREDENTIALS table
$sql_credentials = "CREATE TABLE IF NOT EXISTS CREDENTIALS (
  USERNAME VARCHAR(50) PRIMARY KEY,
  PASSWORD VARCHAR(255) NOT NULL,
  AADHAAR VARCHAR(12) UNIQUE NOT NULL,
  LOGIN_TYPE ENUM('user', 'employee'), -- Enum value
  FOREIGN KEY (AADHAAR) REFERENCES USER(AADHAAR)
);";
$conn->query($sql_credentials); // Execute query

// SQL query to create SCHEME table
$sql_scheme = "CREATE TABLE IF NOT EXISTS SCHEME (
  SCHEME_ID VARCHAR(50) PRIMARY KEY,
  SCHEME_NAME VARCHAR(255) NOT NULL,
  DOMAIN VARCHAR(50) UNIQUE NOT NULL,
  DESCRIPTION TEXT
);";
$conn->query($sql_scheme); // Execute query

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
  <div class="row justify-content-center login-container">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
          <form method="post" action="login.php"> <!-- Set action to login.php -->
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="user_type">Choose login type:</label>
              <select class="form-control" id="login_type" name="login_type">
                <option value="user">User</option>
                <option value="employee">Employee</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center mt-3">
              <a href="choice.php" class="small-link">Create New Account</a> | <a href="#" class="small-link">Forgot Password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Get the 'success' parameter from the URL
  const urlParams = new URLSearchParams(window.location.search);
  const success = urlParams.get('success');

  // Display success message if 'success' parameter is present
  if (success === 'registered') {
    alert("Registration successful! You can now login with your credentials.");
  }

  // Check for error query parameter
  if (urlParams.get('error') === 'invalid_credentials') {
    alert("Invalid username or password. Try again!");
  }
</script>
</body>
</html>
