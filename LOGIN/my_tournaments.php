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
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user's team ID based on their email
$email = $_SESSION['email'];
$team_query = $conn->prepare("SELECT team_id FROM teams WHERE created_by = ?");
$team_query->bind_param("s", $email);
$team_query->execute();
$team_result = $team_query->get_result();
$team = $team_result->fetch_assoc();
$team_id = $team['team_id'];

// Fetch registered tournaments for the user's team
$registered_tournaments_query = $conn->prepare("SELECT t.tournament_id, t.name, t.date, t.slots, t.registration 
    FROM tournaments t 
    JOIN tournament_registrations tr ON t.tournament_id = tr.tournament_id 
    WHERE tr.team_id = ?");
$registered_tournaments_query->bind_param("i", $team_id);
$registered_tournaments_query->execute();
$registered_result = $registered_tournaments_query->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tournaments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Lysto.gg Logo" class="logo">
    </header>
    <main class="tournament-grid">
        <h1>Your Registered Tournaments</h1>
        <?php
        if ($registered_result->num_rows > 0) {
            while($row = $registered_result->fetch_assoc()) {
                echo "<section class='tournament-info'>";
                echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
                echo "<p>Date: <span class='highlight'>" . htmlspecialchars($row["date"]) . "</span></p>";
                echo "<p>Slots Left: <span class='highlight'>" . htmlspecialchars($row["slots"]) . "</span></p>";
                echo "<p>Registration Ends: <span class='highlight'>" . htmlspecialchars($row["registration"]) . "</span></p>";
                echo "</section>";
            }
        } else {
            echo "<p>No registered tournaments found.</p>";
        }
        ?>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>
</body>
</html>

<?php
// Close connections
$team_query->close();
$registered_tournaments_query->close();
$conn->close();
?>
