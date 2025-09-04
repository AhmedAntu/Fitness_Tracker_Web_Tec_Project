<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */
    
    // 
    if(!isset($_SESSION['username'])) {
        $_SESSION['username'] = '...'; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Tracker Dashboard</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body id="antu">
    <h1 id="Header">Fitness Tracker Dashboard</h1>
    
    <?php if(isset($_SESSION['username'])): ?>
        <p style="text-align:center;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <?php endif; ?>
    
    <div id="dashboard">
        <button onclick="location.href='workoutTimer.php'">Workout Timer</button>
        <button onclick="location.href='exerciseLogger.php'">Exercise Logger</button>
        <button onclick="location.href='sessionSum.php'">Session Summary</button>
        <button onclick="location.href='measurement.php'">Measurement Input</button>
        <button onclick="location.href='progressAlbum.php'">Progress Album</button>
        <button onclick="location.href='logout.php'" style="background-color: #d9534f;">Logout</button>
    </div>
</body>
</html>