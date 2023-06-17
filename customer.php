<?php
require_once "backend/app.php";

// Check if the form is submitted and a slot is being booked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_slot'])) {
    $slotId = $_POST['book_slot'];

    // Update the booked status of the slot in the $slots array
    foreach ($slots as &$slot) {
        if ($slot['slot_id'] === $slotId) {
            $slot['booked'] = true;
            break;
        }
    }
}

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
    </div>

    <div class="container body-container">
        <h2 class="text-center">Available Slots</h2>

        <div class="slots-container">
            <?php foreach ($slots as $slot) { ?>
                <form action="" method="post">
                    <div class="<?php echo $slot['booked'] ? 'slot-booked' : 'slot' ?>">
                    <div class="stack-1">
   <img src="https://img-fotki.yandex.ru/get/6836/11092394.0/0_168fcf_d5f873f8_X5L">
</div>
                        <h3><?php echo $slot["slot_name"] ?></h3>
                        <p><?php echo $slot["slot_desc"] ?></p>
                        <p>Available till: <?php echo $slot["slot_date"] ?></p>
                        <?php if (!$slot['booked']) { ?>
                            <button type="submit" name="book_slot" value="<?php echo $slot["slot_id"] ?>" class="btn btn-primary book-btn">Book a Slot</button>
                        <?php } else { ?>
                            <button class="btn btn-danger" disabled>Booked</button>
                        <?php } ?>
                    </div>
                </form>
            <?php } ?>

            <!-- Add more slots here as needed -->

        </div>
       
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>

