<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to authenticate user
function authenticateUser($username, $password, $usertype, $conn) {
    // Sanitize input
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    $usertype = $conn->real_escape_string($usertype);
    
    // Prepare SQL statement with prepared statement
    $sql = "SELECT * FROM users WHERE username=? AND password=? AND usertype=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $usertype);
    
    // Execute SQL statement
    $stmt->execute();
    
    // Check if user exists
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return true; // User authenticated successfully
    } else {
        return false; // Authentication failed
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usertype = $_POST["login_type"]; // Assuming the login type is passed as "login_type" parameter
    
    // Authenticate user
    if (authenticateUser($username, $password, $usertype, $conn)) {
        echo "Authentication successful!";
    } else {
        // Redirect back to login page with error message
        header("Location: login.php?error=invalid_credentials");
        exit;
    }
}

// Close connection
$conn->close();
?>
