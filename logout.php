<?php
session_start();

if(isset($_SESSION['userLoggedIn'])){
    // Unset the userLoggedIn session variable
    unset($_SESSION['userLoggedIn']);
}

// Destroy the session
session_destroy();

// Redirect to the login page
echo '<meta http-equiv="refresh" content="0; url=\'login.php\'" />';
?>
