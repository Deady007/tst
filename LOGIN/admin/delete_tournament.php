<?php
session_start(); // Start the session
include("../config.php"); // Include the database connection

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login_form,php"); // Redirect to the login page if not an admin
    exit();
}

// Check if the tournament ID is set in the URL
if (isset($_GET['id'])) {
    $tournament_id = $_GET['id']; // Get the tournament ID

    // Prepare the delete statement
    $deleteQuery = $conn->prepare("DELETE FROM tournaments WHERE tournament_id = ?");
    $deleteQuery->bind_param("i", $tournament_id); // Bind the tournament ID parameter
    $deleteQuery->execute(); // Execute the delete statement

    // Redirect back to the manage_tournament.php page after deletion
    header("Location: manage_tournaments.php?message=Tournament deleted successfully.");
    exit();
} else {
    // Redirect back with an error message if no ID is provided
    header("Location: manage_tournaments.php?error=No tournament ID specified.");
    exit();
}
?>
