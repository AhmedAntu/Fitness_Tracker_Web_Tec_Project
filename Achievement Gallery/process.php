<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $date = $_POST["date"];

    // Validation
    if (empty($title) || empty($date)) {
        die("⚠️ Please fill in all fields.");
    }

    $today = date("Y-m-d");
    if ($date > $today) {
        die("⚠️ Date cannot be in the future.");
    }

    // Safe output
    echo "✅ Achievement recorded successfully!<br>";
    echo "🏆 Title: " . htmlspecialchars($title) . "<br>";
    echo "📅 Date: " . htmlspecialchars($date) . "<br>";
}
?>
