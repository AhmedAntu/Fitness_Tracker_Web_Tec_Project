<?php
session_start();
if (!isset($_COOKIE['status'])) {
  header('location: login.php?error=badrequest');
  exit();
}
if (!isset($_SESSION['hydration'])) {
  $_SESSION['hydration'] = [
    'goal' => 0,
    'progress' => 0,
    'history' => []
  ];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['set_goal'])) {
    $weight = (int)$_POST['weight'];
    $activity = $_POST['activity'];
    $goal = $weight * 30;
    if ($activity == 'moderate') $goal += 500;
    if ($activity == 'high') $goal += 1000;
    $_SESSION['hydration']['goal'] = floor($goal / 250); 
    $_SESSION['hydration']['progress'] = 0;
    $_SESSION['hydration']['history'] = [];
  }
  if (isset($_POST['log_water'])) {
    if ($_SESSION['hydration']['progress'] < $_SESSION['hydration']['goal']) {
      $_SESSION['hydration']['progress']++;
      
      $_SESSION['hydration']['history'][] = "Glass " . $_SESSION['hydration']['progress'];
    }
  }
  header("Location: hydrationTracker.php");
  exit();
}
$hydration = $_SESSION['hydration'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Hydration Tracker</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    nav {
      background: #0077b6;
      padding: 10px;
      display: flex;
      gap: 20px;
    }

    nav button,
    .back-btn {
      background: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      color: #333;
      font-size: 14px;
    }

    section {
      display: none;
      padding: 20px;
    }

    section.active {
      display: block;
    }

    .card {
      background: #f1f1f1;
      padding: 15px;
      border-radius: 10px;
      margin: 10px 0;
    }

    input,
    select,
    button {
      margin: 5px 0;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .history-log {
      margin-top: 10px;
      background: #fff;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }

    #errorMsg {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <nav>
    <button onclick="showPage('tracker')">Hydration Tracker</button>
    <button onclick="showPage('reminder')">Reminder</button>
    <button onclick="showPage('history')">History</button>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
  </nav>

  
  <section id="tracker" class="active">
    <h2>Hydration Tracker</h2>
    <div class="card">
      <form method="POST" action="hydrationTracker.php">
        <label>Weight (kg):</label><br>
        <input type="number" name="weight" min="20" required><br>
        <label>Activity Level:</label><br>
        <select name="activity" required>
          <option value="">Select</option>
          <option value="low">Low</option>
          <option value="moderate">Moderate</option>
          <option value="high">High</option>
        </select><br>
        <button type="submit" name="set_goal">Set Goal</button>
      </form>
    </div>
    <div class="card">
      <h3 id="goalDisplay">
        Goal: <?php echo $hydration['goal'] > 0 ? $hydration['goal'] . " glasses" : "No goal set"; ?>
      </h3>
      <form method="POST" action="hydrationTracker.php">
        <button type="submit" name="log_water" <?php if ($hydration['goal'] <= 0) echo 'disabled'; ?>>
          Log Water (1 glass)
        </button>
      </form>
      <p id="progressDisplay">
        Progress: <?php echo $hydration['progress']; ?> / <?php echo $hydration['goal']; ?> glasses
      </p>
    </div>
  </section>

  
  <section id="reminder">
    <h2>Reminder</h2>
    <div class="card">
      <label>Set Reminder Interval (minutes):</label><br>
      <input type="number" id="reminderInterval" min="1"><br>
      <button onclick="startReminder()">Start Reminder</button>
      <button onclick="stopReminder()">Stop Reminder</button>
      <p id="reminderMsg">
        <?php if ($hydration['goal'] <= 0) echo "Set a goal first in the tracker."; else echo "Reminder is inactive."; ?>
      </p>
    </div>
  </section>

  
  <section id="history">
    <h2>History</h2>
    <div id="historyList" data-history='<?php echo json_encode($hydration['history']); ?>'></div>
  </section>

  <script>
    let reminderIntervalId = null;

    function showPage(pageId) {
      document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
      document.getElementById(pageId).classList.add('active');
    }

    function startReminder() {
      const intervalInput = document.getElementById('reminderInterval');
      const minutes = parseInt(intervalInput.value, 10);
      const reminderMsg = document.getElementById('reminderMsg');

      if (<?php echo $hydration['goal']; ?> <= 0) {
        reminderMsg.textContent = "Please set a hydration goal first!";
        return;
      }
      if (isNaN(minutes) || minutes < 1) {
        reminderMsg.textContent = "Please enter a valid interval in minutes.";
        return;
      }
      if (reminderIntervalId) {
        clearInterval(reminderIntervalId);
      }
      reminderIntervalId = setInterval(() => {
        alert("Time to drink some water!");
      }, minutes * 60 * 1000);
      reminderMsg.textContent = `Reminder set for every ${minutes} minutes.`;
      intervalInput.value = '';
    }

    function stopReminder() {
      if (reminderIntervalId) {
        clearInterval(reminderIntervalId);
        reminderIntervalId = null;
        document.getElementById('reminderMsg').textContent = "Reminder stopped.";
      }
    }

    
    function renderHistory() {
      let historyContainer = document.getElementById('historyList');
      let historyData = JSON.parse(historyContainer.getAttribute('data-history'));
      historyContainer.innerHTML = "";

      historyData.forEach(function(entry) {
        let now = new Date();
        let timeString = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        let div = document.createElement('div');
        div.className = 'history-log';
        div.innerText = entry + " at " + timeString;
        historyContainer.appendChild(div);
      });
    }

    renderHistory();
  </script>
</body>
</html>
