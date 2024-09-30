<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login_form,php"); // Redirect to login page if not logged in
    exit();
}

// Get the user email (this will be used as the created_by value)
$email = $_SESSION['email'];

// Get the tournament and team IDs from the form submission
$tournament_id = $_POST['tournament_id'];
$team_id = $_POST['team_id'];

// Prepare an insert statement with created_by
$registration_query = $conn->prepare("INSERT INTO tournament_registrations (tournament_id, team_id, created_by) VALUES (?, ?, ?)");
$registration_query->bind_param("iis", $tournament_id, $team_id, $email);

if ($registration_query->execute()) {
    // Registration successful
    echo "Team registered for the tournament successfully!";
} else {
    // Registration failed
    echo "Error: " . $registration_query->error;
}

// Close the connection
$registration_query->close();
$conn->close();

// Redirect to the tournaments page (or any other page you prefer)
header("Location: tournaments.php");
exit();
?>
