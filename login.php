<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
  <div class="row justify-content-center login-container">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
          <form>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
              <label class="d-block">Login as:</label>
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input small-radio" id="employeeRadio" name="loginType" value="employee">
                <label class="form-check-label small-radio" for="employeeRadio">Employee</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input small-radio" id="customerRadio" name="loginType" value="customer">
                <label class="form-check-label small-radio" for="customerRadio">Customer</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center mt-3">
              <a href="#" class="small-link">Create New Account</a> | <a href="#" class="small-link">Forgot Password?</a>
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
