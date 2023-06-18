<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel-booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and bind the SQL statement with placeholders
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            // Set user session or redirect to the appropriate page
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["is_admin"] = $user["is_admin"];

            if ($user['is_admin'] == 1) {
                // Redirect to admin page
                header("Location: admin.php");
            } else {
                // Redirect to customer page
                header("Location: customer.php");
            }
            exit();
        } else {
            // Invalid password
            $errorMessage = "Incorrect password";
        }
    } else {
        // User not found
        $errorMessage = "User not found";
    }

    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container-fluid header">
    <h1>LOGIN</h1>
</div>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center ">Registration successful! You can now log in.</div>
<?php endif; ?>
<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
<?php endif; ?>
<div class="container body-container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="signup-form">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit">Login</button>
                    <br>
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
