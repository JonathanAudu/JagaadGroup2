<?php 


session_start();

if(!isset($_SESSION['userLoggedIn'])){
    echo '<meta http-equiv="refresh" content="0; url=\'login.php\'" />';
}


function  readFromJson(string $fileName):array{
  $slots=[];
  if (file_exists($fileName)) {
    $json = file_get_contents($fileName);
    $slots = json_decode($json, true);
}
return $slots;
}
function addDataTojson(string $fileName, array $data,string $key):void{
  if(is_writable($fileName)){
    $slots =json_decode(file_get_contents($fileName),true);
    $slots[$key]=$data;
    if(!file_put_contents($fileName, json_encode($slots))){
      echo "Cannot write to the file!";
  }
  }
}

if(isset($_POST)){
  if(isset($_POST["add_slot"])&& $_POST["add_slot"]==1){
    $array=readFromJson("data.json");
    $slot_id=count($array)?explode('_',end($array)["slot_id"])[1]+1: 1;
 $slot=[
   "slot_id"=>"slot_".$slot_id,
   "slot_name"=>$_POST["slot_name"],
   "slot_desc"=>$_POST["slot_desc"],
   "slot_date"=>$_POST["slot_date"],
 ];
 if(!empty($_POST["slot_name"])&&!empty($_POST["slot_desc"])&&!empty($_POST["slot_date"]))
 addDataTojson("data.json",$slot,"slot_$slot_id");

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