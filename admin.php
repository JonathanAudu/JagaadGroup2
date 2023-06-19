<?php
session_start();
// Check if the user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    // Redirect to login page or appropriate error page
    header("Location: login.php");
    exit();
}

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

// Initialize variables
$errorMessage = "";

// Fetch slots from the database
$sql = "SELECT * FROM slots";
$result = $conn->query($sql);
$slots = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_slot"])) {
    // Get user input
    $name = $_POST["name"] ?? "";
    $description = $_POST["description"] ?? "";

    // Handle file upload
    $image = $_FILES["image"];
    $imagePath = "uploads/" . basename($image["name"]);  // Specify the directory where you want to save the images

    if (move_uploaded_file($image["tmp_name"], $imagePath)) {
        // File upload successful
        // Prepare and bind the SQL statement with placeholders
        $stmt = $conn->prepare("INSERT INTO slots (user_id, name, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION["user_id"], $name, $description, $imagePath);

        // Execute the statement
        if ($stmt->execute()) {
            // Slot creation successful
            echo '<meta http-equiv="refresh" content="0; url=\'admin.php\'" />';
            $successMessage = "Slot Created Successfully.";
        } else {
            // Slot creation failed
            $errorMessage = "Failed to create slot. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // File upload failed
        $errorMessage = "Failed to upload the image. Please try again.";
    }
}


// Handle the delete action
if (isset($_POST["delete_slot"])) {
    $slotId = $_POST["slot_id"];

    // Prepare and bind the SQL statement with the slot ID as a parameter
    $stmt = $conn->prepare("DELETE FROM slots WHERE id = ?");
    $stmt->bind_param("i", $slotId);

    // Execute the statement
    if ($stmt->execute()) {
        // Slot deletion successful
        echo '<meta http-equiv="refresh" content="0; url=\'admin.php\'" />';
        $successMessage = "Slot Deleted Successfully.";
    } else {
        // Slot deletion failed
        $errorMessage = "Failed to delete slot. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Handle the update action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_slot"])) {
    $slotId = $_POST["slot_id"];
    $slotName = $_POST["slot_name"];
    $slotDescription = $_POST["slot_description"];
    $checkIn = $_POST["check_in"];
    $checkOut = $_POST["check_out"];
    $unbooked = isset($_POST["unbooked"]) ? 1 : 0;

    // Prepare and bind the SQL statement with the slot details as parameters
    $stmt = $conn->prepare("UPDATE slots SET name = ?, description = ?, checkin = ?, checkout = ?, booked = ? WHERE id = ?");
    $stmt->bind_param("ssssii", $slotName, $slotDescription, $checkIn, $checkOut, $unbooked, $slotId);

    // Execute the statement
    if ($stmt->execute()) {
        // Slot update successful
        echo '<meta http-equiv="refresh" content="0; url=\'admin.php\'" />';
        $successMessage = "Slot Updated Successfully.";
    } else {
        // Slot update failed
        $errorMessage = "Failed to update slot. Please try again.";
    }

    // Close the statement
    $stmt->close();
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
    <h1>HOTEL BOOKING SYSTEM ADMIN</h1>
    <?php if ($loggedIn): ?>
        <p>Welcome, <?php echo $_SESSION["email"]; ?>!</p>
        <p class="btn btn-danger"><a href="logout.php" class="text-light">Logout</a></p>
    <?php endif; ?>
    <p class="btn btn-info"><a href="customer.php" class="text-light">Home</a></p>
</div>
<div class="container body-container">
    <h3 class="text-center">Available Slots</h3>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <?php if (isset($successMessage) && !empty($successMessage)): ?>
        <div class="alert alert-success text-center"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Room Description</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Room Image</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
        </div>
        <button type="submit" name="add_slot" class="btn btn-primary">Add Slot</button>
    </form>
</div>

<div class="container body-container">
    <h3 class="text-center">Booked Slots</h3>
    <!-- HTML table -->
    <table>
        <thead>
        <tr>
            <th>Slot Name</th>
            <th>Booked</th>
            <th>Booked User</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Expired</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($slots as $slot): ?>
            <tr>
                <td><?php echo $slot["name"]; ?></td>
                <td><?php echo $slot["booked"] == 1 ? "Yes" : "No"; ?></td>
                <td><?php echo $slot["booked_user"]; ?></td>
                <td><?php echo $slot["checkin"]; ?></td>
                <td><?php echo $slot["checkout"]; ?></td>
                <td><?php echo $slot["expired"] == 1 ? "Yes" : "No"; ?></td>
                <td class="action-buttons">
                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this slot?');">
                        <input type="hidden" name="slot_id" value="<?php echo $slot["id"]; ?>">
                        <button class="btn btn-danger delete-btn" name="delete_slot" type="submit">Delete</button>
                    </form>
                    <button class="btn btn-primary update-btn" value="<?php echo $slot["id"]; ?>" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $slot["id"]; ?>">
                        Update
                    </button>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="updateModal<?php echo $slot["id"]; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $slot["id"]; ?>" aria-hidden="true">
                <form action="" method="post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-center" id="updateModalLabel<?php echo $slot["id"]; ?>">Update Slot</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <input type="hidden" name="slot_name" value="<?php echo $slot["name"]; ?>" class="form-control" id="slotName<?php echo $slot["id"]; ?>">
                                    <input type="hidden" name="slot_description" value="<?php echo $slot["description"]; ?>" class="form-control" id="slotDescription<?php echo $slot["id"]; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="checkIn<?php echo $slot["id"]; ?>" class="form-label">Check-in Date</label>
                                    <input type="date" id="checkIn<?php echo $slot["id"]; ?>" name="check_in" class="form-control" value="<?php echo $slot["checkin"]; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="checkOut<?php echo $slot["id"]; ?>" class="form-label">Check-out Date</label>
                                    <input type="date" id="checkOut<?php echo $slot["id"]; ?>" name="check_out" class="form-control" value="<?php echo $slot["checkout"]; ?>">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="unbooked" value="1" id="unbooked<?php echo $slot["id"]; ?>">
                                    <label class="form-check-label" for="unbooked<?php echo $slot["id"]; ?>">Unbook Slot</label>
                                </div>
                                <input type="hidden" name="slot_id" value="<?php echo $slot["id"]; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="update_slot" value="<?php echo $slot["id"]; ?>" class="btn btn-primary">Update Slot</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Update Slot</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_update" class="form-label">Room Name</label>
                        <input type="text" class="form-control" name="name_update" id="name_update" required>
                    </div>
                    <div class="mb-3">
                        <label for="description_update" class="form-label">Room Description</label>
                        <input type="text" class="form-control" name="description_update" id="description_update" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="slot_id_update" name="slot_id_update">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_slot" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="script.js"></script>
</body>

</html>
