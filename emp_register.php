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

// Function to register employee
function registerEmployee($employee_id, $employee_name, $contact, $mail, $village_code, $username, $password, $conn) {
    // Sanitize input
    
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
    $sql_users = "INSERT INTO employee (employee_id, employee_name, contact, email, village_code)
                  VALUES ('$employee_id', '$employee_name', '$contact', '$mail', '$village_code')";
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
        if (registerEmployee($employee_id, $employee_name, $contact, $mail, $village_code, $username, $password, $conn)) {
            echo "Employee registered successfully!";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Employee Registration</h2>
    <form method="post">
        <div class="form-group">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required>
        </div>
        <div class="form-group">
            <label for="employee_name">Employee Name:</label>
            <input type="text" id="employee_name" name="employee_name" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>
        </div>
        <div class="form-group">
            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" required>
        </div>
        <div class="form-group">
            <label for="village_code">Village Code:</label>
            <input type="text" id="village_code" name="village_code" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Register">
        </div>
    </form>
    <div class="message"><?php echo isset($message) ? $message : ''; ?></div>
</div>

</body>
</html>
