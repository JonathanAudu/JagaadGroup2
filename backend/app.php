<?php
declare(strict_types=1);

// Declare and initialize a variable
$st_number = 1;

// Include the necessary PHP files
require_once "backend/actions.php";
require_once "backend/routing.php";

// Read data from the JSON file using the readFromJson() function
$slots = readFromJson("data.json");
