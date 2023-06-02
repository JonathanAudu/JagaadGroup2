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
  </div>
  <div class="container body-container">
    <h3 class="text-center">Available Slots</h3>
    <form>
      <div class="mb-3">
        <label for="name" class="form-label">Slot Name</label>
        <input type="text" class="form-control" name="Slotname" id="name" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Slot Description</label>
        <input type="text" class="form-control" name="Slot_Desc" id="name" required>
      </div>
      <div class="mb-3">
        <label for="date">Available Date:</label>
        <input type="date" id="date" name="date" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Slot</button>
    </form>
  </div>
  
  <div class="container body-container">
  <h3 class="text-center">Booked Slots</h3>
  <table>
    <thead>
      <tr>
        <th>Slot</th>
        <th>Description</th>
        <th>Date Available</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Slot 1</td>
        <td>Slot 1 description goes here.</td>
        <td>dd/mm/yy</td>
        <td class="action-buttons">
          <button class="btn btn-danger delete-btn">Delete </button>
          <button class="btn btn-primary update-btn"> Update</button>
        </td>
      </tr>
      <tr>
        <td>Slot 2</td>
        <td>Slot 2 description goes here.</td>
        <td>dd/mm/yy</td>
        <td class="action-buttons">
          <button class="btn btn-danger delete-btn">Delete </button>
          <button class="btn btn-primary update-btn"> Update</button>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
 
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="script.js"></script>
</body>

</html>