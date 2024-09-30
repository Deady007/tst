<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to join a team.");
}

$user_email = $_SESSION['email']; // Player's email

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invite_code = $_POST['invite_code'];

    if (empty($invite_code)) {
        die("Invite code is required.");
    }

    // Get team ID using the invite code
    $stmt = $conn->prepare("SELECT team_id FROM team_invitations WHERE invite_code = ?");
    $stmt->bind_param("s", $invite_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $team_id = $row['team_id'];

        // Check if the team already has 4 players
        $stmt_check = $conn->prepare("SELECT COUNT(*) as player_count FROM user_teams WHERE team_id = ?");
        $stmt_check->bind_param("i", $team_id);
        $stmt_check->execute();
        $count_result = $stmt_check->get_result();
        $count_row = $count_result->fetch_assoc();

        if ($count_row['player_count'] < 4) {
            // Add user to the team
            $stmt_join = $conn->prepare("INSERT INTO user_teams (user_email, team_id) VALUES (?, ?)");
            $stmt_join->bind_param("si", $user_email, $team_id);
            if ($stmt_join->execute()) {
                echo "<p>You have successfully joined the team!</p>";
            } else {
                echo "<p>Error: " . $stmt_join->error . "</p>";
            }
            $stmt_join->close();
        } else {
            echo "<p>Team is full. Cannot join the team.</p>";
        }
        $stmt_check->close();
    } else {
        echo "<p>Invalid invite code!</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <title>Join Team</title>
</head>
<body>
    <h1>Join Team</h1>
    <form action="join_team.php" method="post">
        <label for="invite_code">Invite Code:</label>
        <input type="text" id="invite_code" name="invite_code" required>
        <button type="submit">Join Team</button>
    </form>
</body>
</html>
