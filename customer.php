<?php
function  readFromJson(string $fileName):array{
    $slots=[];
    if (file_exists($fileName)) {
      $json = file_get_contents($fileName);
      $slots = json_decode($json, true);
  }
  return $slots;
  }
  $slots=readFromJson("data.json");
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
            <?php  foreach($slots as $slot ){?>
                <form action="">
            <div class="slot">
                <h3><?php echo $slot["slot_name"]?></h3>
                <p><?php echo $slot["slot_desc"]?></p>
                <p>Avalaible till : <?php echo $slot["slot_date"]?></p>
                <button type="submit" name="book-slot" class="btn btn-primary book-btn">Book a Slot</button>
            </div>
            </form>
            <?php }?>
        

            <!-- Add more slots here as needed -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>