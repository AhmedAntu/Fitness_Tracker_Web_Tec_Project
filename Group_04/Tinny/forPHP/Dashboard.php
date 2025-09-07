<?php
session_start();
if (!isset($_COOKIE['status'])) {
  header('location: login.php?error=badrequest');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta>
  <title>Fitness Tracker Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 320px;
    }

    h1 {
      margin-bottom: 20px;
      font-size: 22px;
      color: #333;
    }

    .btn {
      display: block;
      width: 100%;
      box-sizing: border-box;
      margin: 10px 0;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background: #4CAF50;
      color: white;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
    }

    .btn:hover {
      background: #45a049;
    }

    .logout-btn {
      background: #f44336;
    }

    .logout-btn:hover {
      background: #d32f2f;
    }
  </style>
</head>

<body>
  <div class="box">
    <h1>Welcome, <?= $_SESSION['username'] ?>!</h1>
    <a href="hydrationTracker.php" class="btn">Hydration Tracker</a>
    <a href="challengeBoard.php" class="btn">Challenge Board</a>
    <a href="leaderboard.php" class="btn">Leaderboard</a>
    <a href="logout.php" class="btn logout-btn">Logout</a>
  </div>
</body>

</html>



