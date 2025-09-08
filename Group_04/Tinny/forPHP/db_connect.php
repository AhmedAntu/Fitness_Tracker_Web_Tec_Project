<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fitness_tracker';

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
