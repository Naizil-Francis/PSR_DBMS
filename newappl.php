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
$usernames = isset($_GET['username']) ? $_GET['username'] : "Guest";
$l=$usernames;
$aadhaar_info = ""; // Initialize Aadhaar info variable
$message = "";

// Function to logout
function logout() {
    echo "<script>alert('Logged out'); window.location.href = 'index.php';</script>";
}

// Query to fetch Aadhaar details based on username using prepared statement
$sql = "SELECT u.AADHAAR 
        FROM USER u 
        INNER JOIN CREDENTIALS c ON u.AADHAAR = c.AADHAAR 
        WHERE c.USERNAME = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usernames);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any result
if ($result->num_rows > 0) {
    // Fetch the Aadhaar info
    $row = $result->fetch_assoc();
    $aadhaar_info = $row['AADHAAR'];
} else {
    $message = "Username not found.";
}

// Close prepared statement
$stmt->close();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $scheme_id = $_POST['scheme_id'];
    $application_number = $_POST['application_number'];
    $status = $_POST['status'];
    $date_of_applying = $_POST['date_of_applying'];

    // Insert application data into the database
    $sql_insert = "INSERT INTO APPLICATION (SCHEME_ID, AADHAAR, APPLICATION_NUMBER, STATUS, DATE_OF_APPLYING) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $scheme_id, $aadhaar_info, $application_number, $status, $date_of_applying);
    $result_insert = $stmt_insert->execute();

    if ($result_insert) {
        $message = "Application submitted successfully.";
    } else {
        $message = "Error submitting application: " . $conn->error;
    }

    // Close prepared statement
    $stmt_insert->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application</title>
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
    <h3 class="text-center">New Application</h3>
    <?php if (!empty($message)) : ?>
        <div class="alert alert-<?php echo $result_insert ? 'success' : 'danger'; ?>" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="scheme_id">Scheme ID:</label>
            <input type="text" class="form-control" id="scheme_id" name="scheme_id" required>
        </div>
        <div class="form-group">
            <label for="application_number">Application Number:</label>
            <input type="text" class="form-control" id="application_number" name="application_number" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="status" required>
        </div>
        <div class="form-group">
            <label for="date_of_applying">Date of Applying:</label>
            <input type="date" class="form-control" id="date_of_applying" name="date_of_applying" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
  function logout() {
    alert("Logged out"); // Display message
    window.location.href = "index.php"; // Redirect to index.php
  }
</script>
</body>
</html>
