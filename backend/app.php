<?php
declare(strict_types=1);
ini_set('file_uploads', 'On');
use Cloudinary\Configuration\Configuration;
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'my_cloud_name', 
      'api_key' => 'my_key', 
      'api_secret' => 'my_secret'],
    'url' => [
      'secure' => true]]);

// Declare and initialize a variable
$st_number = 1;

// Include the necessary PHP files
require_once "backend/actions.php";
require_once "backend/routing.php";
require 'vendor/autoload.php';

// Read data from the JSON file using the readFromJson() function
$slots = readFromJson("data.json");
