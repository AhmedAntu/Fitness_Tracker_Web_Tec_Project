<?php
session_start();
$username = trim($_REQUEST['username']);
$password = trim($_REQUEST['password']);

if ($username == "" || $password == "") {
    echo "Please type username/password first!";
} else {
    if ($username == 'tinny' && $password == 'tinny@97') {
        setcookie('status', 'true', time() + 3600, '/');
        $_SESSION['username'] = $username;
        header('location: dashboard.php');
    } else {
        header('location: login.php?error=invalid_user');
    }
}

