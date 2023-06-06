<?php
session_start();

$userEmail = 'group2@jagaad.com';
$userPass = '1234';

$username = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if($username == $userEmail && $password == $userPass){
    $_SESSION['userLoggedIn'] = true;
    echo '<meta http-equiv="refresh" content="1; url=\'admin.php\'" />';
} else {
    echo '<meta http-equiv="refresh" content="1; url=\'login.php\'" />';
}