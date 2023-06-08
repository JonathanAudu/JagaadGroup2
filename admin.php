<?php 

print_r($_POST);
session_start();

if(!isset($_SESSION['userLoggedIn'])){
    echo '<meta http-equiv="refresh" content="0; url=\'login.php\'" />';
}

require_once "backend/app.php";
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
  </div>
  <div class="container body-container">
  <ul>
      <li> <?php if(!isset($_SESSION['userLoggedIn'])){ ?>
                <li class="nav-item">
                    <a class="nav-link " href="signin.php">Sign-in</a>
                </li>
            <?php }?></li>
            <li class="nav-item">
                <a class="nav-link " href="logout.php">Sign-out</a>
            </li>
    </ul>
    <h3 class="text-center">Available Slots</h3>
    <form  action method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Check Name</label>
        <input type="text" class="form-control" name="slot_name" id="name" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Check Description</label>
        <input type="text" class="form-control" name="slot_desc" id="name" required>
      </div>
      <div class="mb-3">
        <label for="date">Available Date:</label>
        <input type="date" id="date" name="slot_date" class="form-control" required>
      </div>
      <button type="submit" name="add_slot" value=1 class="btn btn-primary">Add Slot</button>
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
      <?php foreach($slots as $slot){ 
        if($slot['booked']){
        ?>
        <tr>
        <td><?php echo $slot['slot_name']?></td>
        <td><?php echo $slot['slot_desc']?></td>
        <td><?php echo $slot['slot_date']?></td>
        <td class="action-buttons">
          <form action method="post">
          <button class="btn btn-danger delete-btn" name="delete_slot" value="<?php echo  $slot['slot_id'] ?>">Delete </button>
          </form>
          <button class="btn btn-primary update-btn" value="<?php echo('#'.str_replace(' ','-',$slot['slot_id'])); ?>" data-bs-toggle='modal' data-bs-target='<?php echo('#'.str_replace(' ','-',$slot['slot_id'])); ?>'> Update</button>
        </td>
      </tr>
        <?php
        }}?>
    </tbody>
  </table>
  </div>
  <?php  foreach($slots as $slot){
    if($slot['booked']){
    ?>
<!-- Modal -->
<div class="modal fade" id=<?php echo(str_replace(' ','-',$slot["slot_id"]))?> tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form action method="post" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Update Slot</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <div class="mb-2">
     <label for='exampleFormControlInput1' class='form-label'>Slot Name</label>
  <input type='text' name="updated_name_<?php echo $slot["slot_id"] ?>" value="<?php echo htmlspecialchars($slot["slot_name"])?>" class='form-control' id='exampleFormControlInput1' >

</div>
<div class="mb-2">
     <label for='exampleFormControlInput1' class='form-label'>Slot description</label>
  <input type='text' name="updated_desc_<?php echo $slot["slot_id"] ?>" value="<?php echo htmlspecialchars($slot["slot_desc"])?>" class='form-control' id='exampleFormControlInput1' >

</div>

<div class="mb-3">
        <label for="date">Available Date:</label>
        <input type="date" id="date" name="updated_date_<?php echo $slot["slot_id"] ?>" class="form-control" value="<?php echo htmlspecialchars($slot["slot_date"])?>">
      </div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="updated_booked_<?php echo $slot["slot_id"] ?>" value="true" id="flexCheckChecked"  <?php  echo $slot["booked"]? "checked" : " "; ?> >
  <label class="form-check-label" for="flexCheckChecked">
  Booked
  </label>
</div>

<button type="submit" name="update_slot" value="<?php echo $slot["slot_id"] ?>" class="btn btn-primary">Update Slot</button>

      </div>
    </div>
  </div>
  </form>
</div>
<?php }} ?>
 
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="script.js"></script>
</body>

</html>