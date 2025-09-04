<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $goalName = trim($_POST["goalName"]);
    $target = $_POST["target"];
    $deadline = $_POST["deadline"];

    
    if (empty($goalName) || empty($target) || empty($deadline)) {
        die("⚠️ Please fill in all fields.");
    }

    if ($target <= 0) {
        die("⚠️ Target must be greater than 0.");
    }

    $today = date("Y-m-d");
    if ($deadline < $today) {
        die("⚠️ Deadline cannot be in the past.");
    }

    
    echo "✅ Goal added successfully!<br>";
    echo "🎯 Goal: " . htmlspecialchars($goalName) . "<br>";
    echo "📌 Target: " . htmlspecialchars($target) . "<br>";
    echo "📅 Deadline: " . htmlspecialchars($deadline) . "<br>";
}
?>
