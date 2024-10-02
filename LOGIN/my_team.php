<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("<div class='error-message'>You must be logged in to view your teams.</div>");
}

$email = $_SESSION['email'];

// Fetch teams created by the manager, along with their invite codes
$stmt = $conn->prepare("
    SELECT t.team_id, t.team_name, ti.invite_code 
    FROM teams t 
    LEFT JOIN team_invitations ti ON t.team_id = ti.team_id 
    WHERE t.created_by = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Teams</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #343a40;
        }

        ol {
            padding-left: 20px;
        }

        li {
            margin-bottom: 20px;
        }

        ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        li ul li {
            margin-bottom: 5px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .team-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .team-item button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .team-item button:hover {
            background-color: #c82333;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
        }

        .invite-code {
            font-weight: bold;
            color: #007bff;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <a href="dashboard.php">
                <img src="LOGO1.png" alt="fURIOUS EsPORTS Logo" class="logo">
            </a>
        </div>
        <h1>Your Teams</h1>
        <ol>
            <?php
            while ($row = $result->fetch_assoc()) {
                $team_id = $row['team_id'];
                $invite_code = $row['invite_code'] ? htmlspecialchars($row['invite_code']) : 'No invite code';
                echo "<li>
                        <div class='team-item'>
                            <span>" . htmlspecialchars($row['team_name']) . "</span>
                            <span class='invite-code'>Invite Code: $invite_code</span>
                            <form action='delete_team.php' method='post' style='display:inline;'>
                                <input type='hidden' name='team_id' value='" . $team_id . "'>
                                <button type='submit' onclick='return confirm(\"Are you sure you want to delete this team?\");'>Delete Team</button>
                            </form>
                        </div>";
                
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
                
                echo "</li>";
            }
            ?>
        </ol>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
