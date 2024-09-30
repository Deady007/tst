<?php
session_start();
include 'config.php'; // Database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['user_type'] !== 'organizer') {
        die("Unauthorized access.");
    }

    $tournament_id = $_POST['tournament_id'];
    $team_id = $_POST['team_id'];
    $action = $_POST['action']; // 'add' or 'remove'

    if (empty($tournament_id) || empty($team_id) || empty($action)) {
        die("Required parameters are missing.");
    }

    if ($action === 'add') {
        // Add team to tournament
        $stmt = $conn->prepare("INSERT INTO tournament_teams (tournament_id, team_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $tournament_id, $team_id);
    } elseif ($action === 'remove') {
        // Remove team from tournament
        $stmt = $conn->prepare("DELETE FROM tournament_teams WHERE tournament_id = ? AND team_id = ?");
        $stmt->bind_param("ii", $tournament_id, $team_id);
    } else {
        die("Invalid action.");
    }

    if ($stmt->execute()) {
        echo "<p class='success'>Team list updated successfully.</p>";
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Team List</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo">
    </header>
    <main>
        <h1>Modify Team List for Tournament</h1>
        <form action="modify_team_list.php" method="post">
            <label for="tournament_id">Tournament ID:</label>
            <input type="text" id="tournament_id" name="tournament_id" required>
            
            <label for="team_id">Team ID:</label>
            <input type="text" id="team_id" name="team_id" required>
            
            <label for="action">Action:</label>
            <select id="action" name="action" required>
                <option value="add">Add Team</option>
                <option value="remove">Remove Team</option>
            </select>
            
            <button type="submit">Update Team List</button>
        </form>
    </main>
</body>
</html>
