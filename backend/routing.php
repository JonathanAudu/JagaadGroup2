<?php
if(isset($_POST)){
    if(isset($_POST["add_slot"])&& $_POST["add_slot"]==1){
      $array=readFromJson("data.json");
      $slot_id=count($array)?explode('_',end($array)["slot_id"])[1]+1: 1;
   $slot=[
     "slot_id"=>"slot_".$slot_id,
     "slot_name"=>$_POST["slot_name"],
     "slot_desc"=>$_POST["slot_desc"],
     "slot_date"=>$_POST["slot_date"],
     "booked"=>false
   ];
   if(!empty($_POST["slot_name"])&&!empty($_POST["slot_desc"])&&!empty($_POST["slot_date"]))
   addDataTojson("data.json",$slot,"slot_$slot_id");
  
  }
  else if(isset($_POST["delete_slot"])&& array_key_exists( $_POST["delete_slot"],readFromJson("data.json"))){
    $slot_id=$_POST["delete_slot"];
    removeDataFromjson("data.json",$slot_id);
   }
   else if(isset($_POST["update_slot"])&& array_key_exists( $_POST["update_slot"],readFromJson("data.json"))){
    $slot_id=$_POST["update_slot"];
    $slot=[
      "slot_id"=>$slot_id,
      "slot_name"=>$_POST["updated_name_$slot_id"],
      "slot_desc"=>$_POST["updated_desc_$slot_id"],
      "slot_date"=>$_POST["updated_date_$slot_id"],
      "booked"=> isset($_POST["updated_booked_$slot_id"]),
    ];
    updateDataTojson("data.json",$slot,$slot_id);
  
    
   } else if(isset($_POST["book_slot"])&& array_key_exists( $_POST["book_slot"],readFromJson("data.json"))){
    $slot_id=$_POST["book_slot"];
    bookSlot("data.json",$slot_id);
   }

  }