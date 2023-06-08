<?php
session_start();

// Predefined user credentials
$userEmail = 'group2@jagaad.com';
$userPass = '1234';

// Get the submitted username and password from the form
$username = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

// Check if the submitted credentials match the predefined values
if ($username === $userEmail && $password === $userPass) {
    $_SESSION['userLoggedIn'] = true;
    // Redirect to "admin.php" after 1 second
    echo '<meta http-equiv="refresh" content="1; url=/admin.php" />';
} else {
    // Redirect back to "login.php" after 1 second
    echo '<meta http-equiv="refresh" content="1; url=/login.php" />';
}