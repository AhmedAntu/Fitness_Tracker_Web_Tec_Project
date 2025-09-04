<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $goal = $_POST["goal"];
    $current = $_POST["current"];

    // Validation
    if (empty($goal) || empty($current)) {
        die("⚠️ Please fill in all fields.");
    }

    if ($goal <= 0) {
        die("⚠️ Goal must be greater than 0.");
    }

    if ($current < 0) {
        die("⚠️ Current progress cannot be negative.");
    }

    if ($current > $goal) {
        die("⚠️ Progress cannot exceed the goal.");
    }

    // Calculate percentage
    $percent = round(($current / $goal) * 100);

    // Safe output
    echo "✅ Progress tracked successfully!<br>";
    echo "🎯 Goal: " . htmlspecialchars($goal) . "<br>";
    echo "📈 Current: " . htmlspecialchars($current) . "<br>";
    echo "📊 Completion: " . $percent . "%<br>";
}
?>
