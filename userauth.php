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
function registerUser($name, $aadhaar, $address, $ration_card, $phone, $email, $occupation, $username, $password, $conn) {
    // Sanitize input
    $name = $conn->real_escape_string($name);
    $aadhaar = $conn->real_escape_string($aadhaar);
    $address = $conn->real_escape_string($address);
    $ration_card = $conn->real_escape_string($ration_card);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);
    $occupation = $conn->real_escape_string($occupation);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    
    // Check if Aadhaar number is not empty
    if (empty($aadhaar)) {
        return false; // Aadhaar number is empty
    }

    // Begin transaction
    $conn->begin_transaction();

    // Insert into users table
    $sql_users = "INSERT INTO users (aadhaar, name, address, ration_card, phone, email, occupation)
                  VALUES ('$aadhaar', '$name', '$address', '$ration_card', '$phone', '$email', '$occupation')";
    $result_users = $conn->query($sql_users);

    // Insert into credentials table
    $sql_credentials = "INSERT INTO credentials (username, password, aadhaar)
                        VALUES ('$username', '$password', '$aadhaar')";
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
    $aadhaar = $_POST["aadhaar"];
    $address = $_POST["address"];
    $ration_card = $_POST["ration_card"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $occupation = $_POST["occupation"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Register user if Aadhaar number is not empty
    if (!empty($aadhaar)) {
        // Attempt registration
        if (registerUser($name, $aadhaar, $address, $ration_card, $phone, $email, $occupation, $username, $password, $conn)) {
            echo "User registered successfully!";
        } else {
            echo "Error: Registration failed!";
        }
    } else {
        echo "Error: Aadhaar number cannot be empty!";
    }
}

// Close connection
$conn->close();
?>
