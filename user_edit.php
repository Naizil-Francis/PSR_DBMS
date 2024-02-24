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

// Initialize variables
$user = array('NAME' => '', 'EMAIL' => '', 'PHONE' => ''); // Initialize user array to store details
$aadhaar_info = ""; // Initialize Aadhaar info variable

// Check if Aadhaar number is provided in the URL
if (isset($_GET['aadhaar'])) {
    $aadhaar_info = $_GET['aadhaar'];

    // Query to fetch user details based on Aadhaar number
    $sql = "SELECT * FROM USER WHERE AADHAAR = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $aadhaar_info);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch user details
    } else {
        echo "User not found.";
    }

    // Close prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0faff; /* Very light blue background */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center">Edit Details</h3>
    <form method="post" action="update_user.php">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['NAME']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['EMAIL']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['PHONE']); ?>">
        </div>
        <input type="hidden" name="aadhaar" value="<?php echo htmlspecialchars($aadhaar_info); ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
