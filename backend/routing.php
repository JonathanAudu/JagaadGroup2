<?php
// Check if the POST request is set
if(isset($_POST)){

  // Check if the "add_slot" key is set and its value is 1
  if(isset($_POST["add_slot"]) && $_POST["add_slot"] == 1){
    // Read the data from the JSON file
    $array = readFromJson("data.json");

    // Generate a new slot_id based on the existing data
    $slot_id = count($array) ? explode('_', end($array)["slot_id"])[1] + 1 : 1;

    // Create a new slot with the provided details
    $slot = [
      "slot_id" => "slot_".$slot_id,
      "slot_name" => $_POST["slot_name"],
      "slot_desc" => $_POST["slot_desc"],
      "slot_date" => $_POST["slot_date"],
      "booked" => false
    ];

    // Check if all the required fields are filled
    if(!empty($_POST["slot_name"]) && !empty($_POST["slot_desc"]) && !empty($_POST["slot_date"])){
      // Add the new slot data to the JSON file
      addDataTojson("data.json", $slot, "slot_$slot_id");
    }
  }
  // Check if the "delete_slot" key is set and it exists in the JSON data
  else if(isset($_POST["delete_slot"]) && array_key_exists($_POST["delete_slot"], readFromJson("data.json"))){
    // Get the slot_id to be deleted
    $slot_id = $_POST["delete_slot"];
    
    // Remove the slot data from the JSON file
    removeDataFromjson("data.json", $slot_id);
  }
  // Check if the "update_slot" key is set and it exists in the JSON data
  else if(isset($_POST["update_slot"]) && array_key_exists($_POST["update_slot"], readFromJson("data.json"))){
    // Get the slot_id to be updated
    $slot_id = $_POST["update_slot"];

    // Create an updated slot with the provided details
    $slot = [
      "slot_id" => $slot_id,
      "slot_name" => $_POST["updated_name_$slot_id"],
      "slot_desc" => $_POST["updated_desc_$slot_id"],
      "slot_date" => $_POST["updated_date_$slot_id"],
      "booked" => isset($_POST["updated_booked_$slot_id"]),
    ];

    // Update the slot data in the JSON file
    updateDataTojson("data.json", $slot, $slot_id);
  }
  // Check if the "book_slot" key is set and it exists in the JSON data
  else if(isset($_POST["book_slot"]) && array_key_exists($_POST["book_slot"], readFromJson("data.json"))){
    // Get the slot_id to be booked
    $slot_id = $_POST["book_slot"];

    // Book the slot by updating the "booked" status in the JSON file
    bookSlot("data.json", $slot_id);
  }
}
?>
