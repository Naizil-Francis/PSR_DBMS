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

// Function to register user
function registerUser($name, $employee_id, $employee_name, $contact, $mail, $village_code, $username, $password, $conn) {
    // Sanitize input
    $name = $conn->real_escape_string($name);
    $employee_id = $conn->real_escape_string($employee_id);
    $employee_name = $conn->real_escape_string($employee_name);
    $contact = $conn->real_escape_string($contact);
    $mail = $conn->real_escape_string($mail);
    $village_code = $conn->real_escape_string($village_code);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    
    // Check if employee ID is not empty
    if (empty($employee_id)) {
        return false; // Employee ID is empty
    }

    // Begin transaction
    $conn->begin_transaction();

    // Insert into users table
    $sql_users = "INSERT INTO user (name, employee_id, employee_name, contact, email, village_code)
                  VALUES ('$name', '$employee_id', '$employee_name', '$contact', '$mail', '$village_code')";
    $result_users = $conn->query($sql_users);

    // Insert into credentials table
    $sql_credentials = "INSERT INTO credentials (username, password, employee_id, login_type)
                        VALUES ('$username', '$password', '$employee_id','user')";
    $result_credentials = $conn->query($sql_credentials);

    // Commit transaction if both queries succeed, otherwise rollback
    if ($result_users && $result_credentials) {
        $conn->commit();
        return true; // User registered successfully
    } else {
        $conn->rollback();
        return false; // Registration failed
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $employee_id = $_POST["employee_id"];
    $employee_name = $_POST["employee_name"];
    $contact = $_POST["contact"];
    $mail = $_POST["mail"];
    $village_code = $_POST["village_code"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Register user if Employee ID is not empty
    if (!empty($employee_id)) {
        // Attempt registration
        if (registerUser($name, $employee_id, $employee_name, $contact, $mail, $village_code, $username, $password, $conn)) {
            echo "User registered successfully!";
        } else {
            echo "Error: Registration failed!";
        }
    } else {
        echo "Error: Employee ID cannot be empty!";
    }
}

// Close connection
$conn->close();
?>
