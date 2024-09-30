<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to delete a team.");
}

// Check if team_id is provided
if (isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM teams WHERE team_id = ?");
    $stmt->bind_param("i", $team_id);
    
    if ($stmt->execute()) {
        echo "<p>Team deleted successfully.</p>";
    } else {
        echo "<p>Error deleting team: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>No team ID provided.</p>";
}

$conn->close();

// Redirect back to my_team.php
header("Location: my_team.php");
exit();
?>
