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
$usernames = isset($_GET['username']) ? $_GET['username'] : "";
$l=$usernames;
$aadhaar_info = ""; // Initialize Aadhaar info variable
$message = ""; // Initialize message variable
$user = array('NAME' => '', 'EMAIL' => '', 'CONTACT' => ''); // Initialize user array to store details
$stmt_user = null; // Initialize $stmt_user outside of the if block

// Check if username is provided in the URL
if (!empty($usernames)) {
    // Query to fetch Aadhaar details based on username
    $sql_usernames = "SELECT AADHAAR FROM CREDENTIALS WHERE USERNAME = ?";
    $stmt_usernames = $conn->prepare($sql_usernames);
    $stmt_usernames->bind_param("s", $usernames);
    $stmt_usernames->execute();
    $result_usernames = $stmt_usernames->get_result();

    // Check if username exists
    if ($result_usernames->num_rows > 0) {
        $row_usernames = $result_usernames->fetch_assoc();
        $aadhaar_info = $row_usernames['AADHAAR']; // Get Aadhaar information

        // Query to fetch user details based on Aadhaar number
        $sql_user = "SELECT * FROM USER WHERE AADHAAR = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("s", $aadhaar_info);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        // Check if user exists
        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc(); // Fetch user details
        } else {
            $message = "User not found.";
        }
    } else {
        $message = "Username not found.";
    }

    // Close prepared statements
    $stmt_usernames->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Update user information in the database
    $sql_update = "UPDATE USER SET NAME=?, EMAIL=?, CONTACT=? WHERE AADHAAR=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssss", $name, $email, $contact, $aadhaar_info);
    $result_update = $stmt_update->execute();

    if ($result_update) {
        $message = "User information updated successfully.";
        $user['NAME'] = $name; // Update name in user array
        
        // Redirect to usermain.php with username
        header("Location: usermain.php?username=$usernames");
        exit(); // Ensure script execution stops here
    } else {
        $message = "Error updating user information: " . $conn->error;
    }

    // Close prepared statement
    $stmt_update->close();
}

// Close $stmt_user if it's not null
if ($stmt_user !== null) {
    $stmt_user->close();
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
<?php $usernames = isset($_GET['username']) ? $_GET['username'] : ""; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="usermain.php?username=<?php echo $usernames ?>">HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="edit_info_user.php?username=<?php echo $usernames ?>">Edit Details</a>
            </li>
        </ul>
        <span class="navbar-text mr-3">
            Welcome, <?php echo $usernames ?> <!-- Display the username -->
        </span>
        <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="logout()">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="text-center">Edit Details</h3>
    <div id="message" class="text-center mb-3"><?php echo $message; ?></div>
    <form id="editForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['NAME']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['EMAIL']); ?>">
        </div>
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($user['CONTACT']); ?>">
        </div>
        <button id="submitButton" type="submit" class="btn btn-primary" onclick="edit_info_user.php?username=<?php echo $usernames ?>">Submit</button>
    </form>
</div>

<script>
// Display message using JavaScript
window.onload = function() {
    var message = document.getElementById("message").innerText;
    if (message !== "") {
        alert(message);
    }
};

// Function to logout
function logout() {
    alert("Logged out"); // Display message
    window.location.href = "index.php"; // Redirect to index.php
}
</script>

</body>
</html>
