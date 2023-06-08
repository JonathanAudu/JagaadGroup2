<?php
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
  
  function removeDataFromjson(string $fileName, string $key){
    if(is_writable($fileName)){
      $slots =json_decode(file_get_contents($fileName),true);
      unset($slots[$key]);
      if(!file_put_contents($fileName, json_encode($slots))){
        echo "Cannot write to the file!";
    }
    }
  }
  function bookSlot(string $fileName, string $key){
    if(is_writable($fileName)){
      $slots =json_decode(file_get_contents($fileName),true);
      $slots[$key]["booked"]=true;
      if(!file_put_contents($fileName, json_encode($slots))){
        echo "Cannot write to the file!";
    }
    }
  }
  function updateDataTojson(string $fileName, array $data,string $key):void{
    if(is_writable($fileName)){
      $slots =json_decode(file_get_contents($fileName),true);
      $slots[$key]=$data;
      if(!file_put_contents($fileName, json_encode($slots))){
        echo "Cannot write to the file!";
    }
    }
  }