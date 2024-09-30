<?php
session_start();
include("config.php");

// Check if the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login_form,php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = isset($_POST['team_id']) ? intval($_POST['team_id']) : 0;

    if ($team_id > 0) {
        // Prepare and execute the deletion query
        $deleteQuery = $conn->prepare("DELETE FROM teams WHERE id = ?");
        $deleteQuery->bind_param("i", $team_id);

        if ($deleteQuery->execute()) {
            echo "Team deleted successfully.";
        } else {
            echo "Error deleting team: " . $conn->error;
        }

        $deleteQuery->close();
    } else {
        echo "Invalid team ID.";
    }
}
?>
