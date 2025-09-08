<?php
$con = mysqli_connect('127.0.0.1', 'root', '', 'sessionSummary');

if (!$con) {
    echo "Database connection failed: " . mysqli_connect_error();
}
?>
