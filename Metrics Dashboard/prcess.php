<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST["date"];
    $strength = $_POST["strength"];
    $cardio = $_POST["cardio"];

    
    if (empty($date) || empty($strength) || empty($cardio)) {
        die("⚠️ Please fill in all fields.");
    }

    if ($strength < 0 || $cardio < 0) {
        die("⚠️ Values cannot be negative.");
    }

    echo "✅ Data received successfully!<br>";
    echo "📅 Date: " . htmlspecialchars($date) . "<br>";
    echo "💪 Strength: " . htmlspecialchars($strength) . " kg<br>";
    echo "🏃 Cardio: " . htmlspecialchars($cardio) . " minutes<br>";
}
?>
