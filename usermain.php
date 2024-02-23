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
  <a class="navbar-brand" href="#">Available Schemes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="my_applications.php">Available Schemes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="new_application.php">New Application</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="edit_details.php">Edit Details</a>
      </li>
    </ul>
    <?php
    // Check if the username is set in the session or database
    $username = "John Doe"; // Example username, replace with actual logic to retrieve username
    ?>
    <span class="navbar-text mr-3">
        Welcome, <?php echo $username; ?> <!-- Display the username -->
    </span>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="logout()">Logout</button>
    </form>
  </div>
</nav>

<?php
// Database configuration
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

// SQL query to select data from SCHEME table
$sql = "SELECT * FROM SCHEME";
$result = $conn->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<div class='container mt-5'>";
    echo "<h3 class='text-center'>Schemes Available</h3>";
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
    $counter = 1; // Initialize counter variable
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter++ . "</td>"; // Increment the counter for each row
        echo "<td>" . $row["SCHEME_ID"] . "</td>";
        echo "<td>" . $row["SCHEME_NAME"] . "</td>";
        echo "<td>" . $row["DOMAIN"] . "</td>";
        echo "<td>" . $row["DESCRIPTION"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='container mt-5'>";
    echo "<h3 class='text-center'>No schemes found</h3>"; // Center aligned message
    echo "</div>";
}

// Close connection
$conn->close();
?>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JavaScript for logout functionality -->
<script>
  function logout() {
    alert("Logged out"); // Display message
    window.location.href = "index.php"; // Redirect to index.php
  }
</script>

</body>
</html>
