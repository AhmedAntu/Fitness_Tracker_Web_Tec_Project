<?php
session_start();
require_once("../model/db.php");


    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */
    if(!isset($_SESSION['username'])) {
        $_SESSION['username'] = 'Touhid Ahmed Antu'; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Tracker Dashboard</title>
    <link rel="stylesheet" href="/Fitness_Tracker_Web_Tec_Project/Group_04/Antu/asset/style.css">


</head>
<body id="antu">
    <h1 id="Header">Fitness Tracker Dashboard</h1>
    
    <?php if(isset($_SESSION['username'])): ?>
        <p style="text-align:center;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <?php endif; ?>
    
    <div id="dashboard">
        <button onclick="location.href='../view/workoutTimer.php'">Workout Timer</button>
        <button onclick="location.href='../view/exerciseLogger.php'">Exercise Logger</button>
        <button onclick="location.href='../view/sessionSum.php'">Session Summary</button>
        <button onclick="location.href='../view/measurement.php'">Measurement Input</button>
        <button onclick="location.href='../view/progressAlbum.php'">Progress Album</button>
        <button onclick="location.href='../controller/logout.php'" style="background-color: #d9534f;">Logout</button>
    </div>
</body>
</html>
