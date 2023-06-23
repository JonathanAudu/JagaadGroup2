<?php
// Check if the user is logged in
$loggedIn = isset($_SESSION["user_id"]);
$isAdmin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1;
if($_SERVER["REQUEST_URI"]==="/admin.php"){
    if(!$loggedIn && !$isAdmin){
        // Redirect to login page or appropriate error page
    header("Location: login.php");
    exit();
    }
}