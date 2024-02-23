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
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the created database
$conn->select_db($database);

// SQL query to create table
$sql = "CREATE TABLE IF NOT EXISTS your_table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    column1 VARCHAR(30) NOT NULL,
    column2 VARCHAR(30) NOT NULL,
    column3 INT(10)
)";

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();
?>
