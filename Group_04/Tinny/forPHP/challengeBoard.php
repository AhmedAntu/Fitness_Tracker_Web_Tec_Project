<?php
session_start();
require_once('db_connect.php');

if (!isset($_COOKIE['status'])) {
  header('location: login.php?error=badrequest');
  exit();
}

if (!isset($_SESSION['cheers'])) {
  $_SESSION['cheers'] = [];
}
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_challenge'])) {
  $friend = trim($_POST["friend"]);
  $type = $_POST["type"];
  $target = $_POST["target"];
  $date = date("Y-m-d");


  $friend_safe = mysqli_real_escape_string($con, $friend);
  $type_safe = mysqli_real_escape_string($con, $type);
  $target_safe = mysqli_real_escape_string($con, $target);

  $sql = "INSERT INTO challenges (friend_name, challenge_type, target_number, challenge_date) VALUES ('$friend_safe', '$type_safe', '$target_safe', '$date')";

  if (mysqli_query($con, $sql)) {
    $successMessage = "Challenge added successfully!";
  } else {
    $successMessage = "Error: " . mysqli_error($con);
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_cheer'])) {
  $cheerMessage = trim($_POST["cheerMessage"]);
  if (!empty($cheerMessage)) {
    $_SESSION['cheers'][] = htmlspecialchars($cheerMessage);
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Friend Fitness Challenges</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2 {
      text-align: center;
      color: #333;
    }

    form fieldset {
      border: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    label {
      font-weight: bold;
    }

    input,
    select,
    button {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button {
      background: #4CAF50;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #45a049;
    }

    .link-btn,
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 14px;
      background: #2196F3;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      text-align: center;
      border: none;
      font-size: 14px;
      cursor: pointer;
    }

    .link-btn:hover {
      background: #0b7dda;
    }

    .cheer-section {
      margin-top: 30px;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: 3px;
      display: block;
    }

    #cheerBoard {
      margin-top: 15px;
      list-style: none;
      padding: 0;
    }

    #cheerBoard li {
      background: #e3f2fd;
      margin: 5px 0;
      padding: 10px;
      border-radius: 6px;
    }

    .success {
      color: green;
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Create a Fitness Challenge</h1>
    <?php if ($successMessage): ?>
      <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form id="challengeForm" method="post" action="challengeBoard.php">
      <fieldset>
        <label for="friend">Friend Name:</label>
        <input type="text" id="friend" name="friend" required minlength="2">
        <span id="friendError" class="error"></span>
        <label for="type">Challenge Type:</label>
        <select id="type" name="type" required>
          <option value="">--Select--</option>
          <option value="Steps">Steps</option>
          <option value="Push-ups">Push-ups</option>
          <option value="Squats">Squats</option>
          <option value="Plank">Plank</option>
          <option value="Burpees">Burpees</option>
          <option value="Jumping Jacks">Jumping Jacks</option>
          <option value="Crunches">Crunches</option>
          <option value="Lunges">Lunges</option>
          <option value="Mountain Climbers">Mountain Climbers</option>
        </select>
        <span id="typeError" class="error"></span>
        <label for="target">Target Number:</label>
        <input type="number" id="target" name="target" required min="1">
        <span id="targetError" class="error"></span>
        <button type="submit" name="add_challenge">Add Challenge</button>
      </fieldset>
    </form>
    <div class="cheer-section">
      <h2>Cheer Your Friend</h2>
      <form id="cheerForm" method="post" action="challengeBoard.php">
        <input type="text" id="cheerMessage" name="cheerMessage" placeholder="Write a cheer..." required>
        <button type="submit" name="send_cheer">Send Cheer</button>
      </form>
      <ul id="cheerBoard">
        <?php foreach ($_SESSION['cheers'] as $cheer): ?>
          <li><?php echo $cheer; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <a href="leaderboard.php" class="link-btn">Go to Leaderboard</a>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
  </div>
  <script>
    document.getElementById("challengeForm").addEventListener("submit", function(e) {
      let isValid = true;
      var friend = document.getElementById("friend").value;
      var friendError = document.getElementById("friendError");
      friendError.textContent = "";
      if (friend === "" || friend.length < 2) {
        friendError.textContent = "Friend name is required.";
        isValid = false;
      }
      var type = document.getElementById("type").value;
      var typeError = document.getElementById("typeError");
      typeError.textContent = "";
      if (type === "") {
        typeError.textContent = "Please select a challenge type.";
        isValid = false;
      }
      var target = document.getElementById("target").value;
      var targetError = document.getElementById("targetError");
      targetError.textContent = "";
      if (target === "" || parseInt(target) < 1) {
        targetError.textContent = "Target number must be at least 1.";
        isValid = false;
      }
      if (!isValid) {
        e.preventDefault();
      }
    });
  </script>
</body>

</html>