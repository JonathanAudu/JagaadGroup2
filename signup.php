<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel-booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Initialize variables for error messages
$emailError = "";
$passwordError = "";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate email
    if (empty($email)) {
        $emailError = "Email is required";
    }

    // Validate password
    if (empty($password)) {
        $passwordError = "Invalid details";
    }

    // If there are no errors, proceed with registration
    if (empty($emailError) && empty($passwordError)) {
        // Hash the password using bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page with success message
            header("Location: login.php?success=1");
            exit();
        } 

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
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
            <?php if (!empty($passwordError)): ?>
            <div class="alert alert-danger text-center"><?php echo $passwordError; ?></div>
            <?php endif; ?>
          <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
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