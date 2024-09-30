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

// Fetch user email
$email = $_SESSION['email'];

// Fetch teams for the dropdown based on the created_by field
$teams_query = $conn->prepare("SELECT team_id, team_name FROM teams WHERE created_by = ?");
$teams_query->bind_param("s", $email);
$teams_query->execute();
$teams_result = $teams_query->get_result();

// Fetch tournaments for dropdown
$tournaments_query = $conn->prepare("SELECT tournament_id, name FROM tournaments");
$tournaments_query->execute();
$tournaments_result = $tournaments_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Tournament</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Lysto.gg Logo" class="logo">
    </header>
    <main>
        <h1>Register for Tournament</h1>
        <form action="process_registration.php" method="post">
            <label for="tournament">Select Tournament:</label>
            <select name="tournament_id" id="tournament" required>
                <option value="">Select a tournament</option>
                <?php
                while ($tournament = $tournaments_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($tournament['tournament_id']) . "'>" . htmlspecialchars($tournament['name']) . "</option>";
                }
                ?>
            </select>

            <label for="team">Select Team:</label>
            <select name="team_id" id="team" required>
                <option value="">Select a team</option>
                <?php
                while ($team = $teams_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($team['team_id']) . "'>" . htmlspecialchars($team['team_name']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Register</button>
        </form>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>
</body>
</html>
