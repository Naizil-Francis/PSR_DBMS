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
$aadhaar_info = "Aadhaar info not found";
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

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Application Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0faff; /* Very light blue background */
        }
        .navbar {
            background-color: #007bff !important; /* Blue navbar */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="newappl.php?username=<?php echo $usernames; ?>">New Application</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="edit_info_user.php?username=<?php echo $usernames; ?>">Edit Details</a>
            </li>
        </ul>
        <span class="navbar-text mr-3">
            Welcome, <?php echo $usernames; ?> <!-- Display the username -->
        </span>
        <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="logout()">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="text-center">Schemes Available</h3>
    <?php if (!empty($message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php else: ?>
        <?php
        // Create a new connection to fetch scheme data
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM SCHEME";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Sl. No.</th>";
            echo "<th scope='col'>Scheme ID</th>";
            echo "<th scope='col'>Scheme Name</th>";
            echo "<th scope='col'>Domain</th>";
            echo "<th scope='col'>Description</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $counter++ . "</td>";
                echo "<td>" . $row["SCHEME_ID"] . "</td>";
                echo "<td>" . $row["SCHEME_NAME"] . "</td>";
                echo "<td>" . $row["DOMAIN"] . "</td>";
                echo "<td>" . $row["DESCRIPTION"] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No schemes found.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    <?php endif; ?>
</div>
<script>
  function logout() {
    alert("Logged out"); // Display message
    window.location.href = "index.php"; // Redirect to index.php
  }
</script>
</body>
</html>
