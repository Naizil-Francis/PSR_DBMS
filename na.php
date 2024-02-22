<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
  <style>
    .center {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Register
        </div>
        <div class="card-body">
          <form method="post" action="userauth.php"> <!-- Set action to register.php -->
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
            <div class="form-group">
              <label for="aadhaar">Aadhaar Number</label>
              <input type="text" class="form-control" id="aadhaar" name="aadhaar" placeholder="Enter Aadhaar number">
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
            </div>
            <div class="form-group">
              <label for="ration_card">Ration Card Number</label>
              <input type="text" class="form-control" id="ration_card" name="ration_card" placeholder="Enter ration card number">
            </div>
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
            </div>
            <div class="form-group">
              <label for="email">Email ID</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email ID">
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
              <label for="occupation">Occupation</label>
              <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Enter your occupation">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <div class="text-center mt-3">
              <a href="login.php" class="small-link">Already have an account? Login here</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
