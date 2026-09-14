<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "clubsphere_db";

$conn = mysqli_connect($host, $user, $password);
if (!$conn) {
    die("Connection failed");
}

DROP TABLE IF EXISTS tournaments;

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
mysqli_query($conn, $sql);
mysqli_select_db($conn, $dbName);

$table1 = "CREATE TABLE IF NOT EXISTS captains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    real_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    ign VARCHAR(50) NOT NULL,
    game VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $table1);

$table2 = "CREATE TABLE IF NOT EXISTS rosters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    captain_id INT NOT NULL,
    real_name VARCHAR(100) NOT NULL,
    ign VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL
)";
mysqli_query($conn, $table2);

mysqli_query($conn, "DROP TABLE IF EXISTS tournaments");

$table3 = "CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    game VARCHAR(50) NOT NULL,
    event_date DATE NOT NULL
)";
mysqli_query($conn, $table3);

$table4 = "CREATE TABLE IF NOT EXISTS tournament_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    captain_id INT NOT NULL,
    tournament_id INT NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending'
)";
mysqli_query($conn, $table4);

$table5 = "CREATE TABLE IF NOT EXISTS match_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    captain_id INT NOT NULL,
    tournament_id INT NOT NULL,
    score VARCHAR(50) NOT NULL,
    proof_image VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending Review'
)";
mysqli_query($conn, $table5);

$insert = "INSERT IGNORE INTO tournaments (id, title, game, event_date) VALUES 
(1, 'Challenger League Open Qualifiers', 'VALORANT', '2026-10-15'),
(2, 'FC26 Winter Cup', 'FC26', '2026-11-01')";
mysqli_query($conn, $insert);
?>