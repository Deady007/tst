<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to view your teams.");
}

$email = $_SESSION['email'];

// Fetch teams created by the manager
$stmt = $conn->prepare("SELECT team_id, team_name FROM teams WHERE created_by = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Your Teams</h1>";
echo "<ol>"; // Use ordered list for numbering

while ($row = $result->fetch_assoc()) {
    $team_id = $row['team_id'];
    echo "<li>" . htmlspecialchars($row['team_name']);
    
    // Add delete button for the team
    echo " <form action='delete_team.php' method='post' style='display:inline;'>
            <input type='hidden' name='team_id' value='" . $team_id . "'>
            <button type='submit' onclick='return confirm(\"Are you sure you want to delete this team?\");'>Delete Team</button>
          </form>";

    // Fetch players in the team along with their usernames
    $stmt_players = $conn->prepare("
        SELECT u.username, u.email 
        FROM user_teams ut 
        JOIN users u ON ut.user_email = u.email 
        WHERE ut.team_id = ?
    ");
    $stmt_players->bind_param("i", $team_id);
    $stmt_players->execute();
    $players_result = $stmt_players->get_result();

    echo "<ul>";
    while ($player_row = $players_result->fetch_assoc()) {
        // Create a clickable link for the player's username
        echo "<li><a href='my_profile.php?email=" . urlencode($player_row['email']) . "'>" . htmlspecialchars($player_row['username']) . "</a></li>";
    }
    echo "</ul>";

    echo "</li>"; // Close list item
}

echo "</ol>"; // Close ordered list

$stmt->close();
$conn->close();

?>
