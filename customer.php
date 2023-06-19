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

// Check if the user is logged in
$loggedIn = isset($_SESSION["user_id"]);
$isAdmin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1;

// Set the session timeout duration (in seconds)
$sessionTimeout = 7200; // 2 hours

// Update the last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();


// Fetch slots from the database
$sql = "SELECT * FROM slots";
$result = $conn->query($sql);
$slots = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}

// Update expired slots
$updateExpiredSql = "UPDATE slots SET expired = 1 WHERE checkout < CURDATE()";
$conn->query($updateExpiredSql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book_slot"])) {
    // Retrieve user email from the session
    $userEmail = $_SESSION["email"] ?? null;
    if (!$userEmail) {
        $errorMessage = "YOU HAVE TO LOGIN TO BOOK A ROOM.";
    } else {
        $slotId = $_POST["slot_id"];

        // Check if the slot is already booked
        $checkBookedSql = "SELECT booked FROM slots WHERE id = ?";
        $checkBookedStmt = $conn->prepare($checkBookedSql);
        $checkBookedStmt->bind_param("i", $slotId);
        $checkBookedStmt->execute();
        $checkBookedStmt->bind_result($booked);
        $checkBookedStmt->fetch();
        $checkBookedStmt->close();

        if ($booked) {
            $errorMessage = "Slot is already booked.";
        } else {
            $checkin = $_POST['checkin'];
            $checkout = $_POST['checkout'];

            // Update the slot with booked status and user email
            $updateSql = "UPDATE slots SET booked = 1, booked_user = ?, checkin = ?, checkout = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("sssi", $userEmail, $checkin, $checkout, $slotId);

            if ($stmt->execute()) {
                $successMessage = "Slot booked successfully!";
                echo '<meta http-equiv="refresh" content="0; url=\'customer.php\'" />';
            } else {
                $errorMessage = "Error booking slot: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

</head>

<body>
<div class="container-fluid header">
    <h1>HOTEL BOOKING SYSTEM</h1>
    <?php if ($loggedIn): ?>
        <p>Welcome, <?php echo $_SESSION["email"]; ?>!</p>
        <?php if ($isAdmin): ?>
            <p class="btn btn-success"><a href="admin.php" class="text-light">Dashboard</a></p>
        <?php endif; ?>
        <p class="btn btn-danger"><a href="logout.php" class="text-light">Logout</a></p>
    <?php else: ?>
        <p class="btn btn-success"><a href="login.php" class="text-light">Login</a></p>
    <?php endif; ?>
</div>

<div class="container body-container">
    <h2 class="text-center">Available Slots</h2>
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success text-center"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <hr>
    <div class="slots-container">
        <?php if (empty($slots)): ?>
            <p>No slots available.</p>
        <?php else: ?>
            <?php foreach ($slots as $slot): ?>
                <div class="slot">
                    <div class="card">
                        <img src="<?php echo $slot['image']; ?>" class="card-img-top" alt="image here" height="250px" width="70px">
                        <div class="card-body">
                            <h3><?php echo $slot["name"] ?></h3>
                            <p><?php echo $slot["description"] ?></p>
                            <?php if ($slot["expired"]): ?>
                                <p class="btn btn-warning">Expired</p>
                            <?php elseif ($slot["booked"]): ?>
                                <p class="btn btn-danger">Booked</p>
                            <?php else: ?>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#bookSlotModal_<?php echo $slot["id"] ?>">Book Slot
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Book Slot Modal -->
                <div class="modal fade" id="bookSlotModal_<?php echo $slot["id"] ?>" tabindex="-1"
                     aria-labelledby="bookSlotModalLabel_<?php echo $slot["id"] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookSlotModalLabel_<?php echo $slot["id"] ?>">Book Slot</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="slot_id" value="<?php echo $slot["id"] ?>">
                                    <div class="form-group">
                                        <label for="checkin_<?php echo $slot["id"] ?>">Check-in Date</label>
                                        <input type="date" id="checkin_<?php echo $slot["id"] ?>" name="checkin"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout_<?php echo $slot["id"] ?>">Check-out Date</label>
                                        <input type="date" id="checkout_<?php echo $slot["id"] ?>" name="checkout"
                                               required>
                                    </div>
                                    <button type="submit" name="book_slot" class="btn btn-primary">Book Slot</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
