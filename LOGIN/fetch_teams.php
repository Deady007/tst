<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_GET['tournament_id'])) {
    die("Tournament ID is required.");
}

$tournament_id = $_GET['tournament_id'];
$teams = [];

// Fetch teams for the selected tournament
$stmt = $conn->prepare("SELECT teams.team_id, teams.team_name FROM teams 
                         JOIN tournament_registrations ON teams.team_id = tournament_registrations.team_id 
                         WHERE tournament_registrations.tournament_id = ?");
$stmt->bind_param("i", $tournament_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $teams[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($teams);
