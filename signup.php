<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Booking System Sighup</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-fluid header">
    <h1>REGISTRATION</h1>
  </div>
  <div class="container body-container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="signup-form">

          <form action="" method="POST">

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Enter your email">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit">Signup</button><br>
            <p>Have an account already, <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>