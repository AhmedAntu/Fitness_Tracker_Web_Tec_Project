<?php
session_start();
require_once('db_connect.php');

if (!isset($_COOKIE['status'])) {
  header('location: login.php?error=badrequest');
  exit();
}

$sql = "SELECT * FROM challenges ORDER BY id DESC";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Challenge Leaderboard</title>
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th {
      background: #2196F3;
      color: white;
      padding: 10px;
    }

    td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
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

    .back-btn {
      background-color: #2196F3;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Challenge Leaderboard</h1>
    <table>
      <thead>
        <tr>
          <th>Friend Name</th>
          <th>Type</th>
          <th>Target Number</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody id="leaderboardBody">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['friend_name']); ?></td>
              <td><?php echo htmlspecialchars($row['challenge_type']); ?></td>
              <td><?php echo htmlspecialchars($row['target_number']); ?></td>
              <td><?php echo htmlspecialchars($row['challenge_date']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" style="text-align:center;">No challenges added yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="challengeBoard.php" class="link-btn">Back to Challenges</a>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
  </div>
</body>

</html>