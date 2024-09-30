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

// Fetch user type from the database
$email = $_SESSION['email'];
$query = $conn->prepare("SELECT user_type FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_type = $user['user_type'];

// Fetch tournaments data
$sql = "SELECT * FROM tournaments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Lysto.gg Logo" class="logo">
    </header>
    <main class="tournament-grid">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<section class='tournament-info'>";
                echo "<div class='banner'>";
                echo "<img src='" . htmlspecialchars($row["banner"]) . "' alt='Tournament Banner'>";
                echo "</div>";
                echo "<div class='details'>";
                echo "<h1>" . htmlspecialchars($row["name"]) . "</h1>";
                echo "<p class='game-name'>Game: <span class='highlight'>" . htmlspecialchars($row["game"]) . "</span></p>";
                echo "<p class='game-type'>Type: <span class='highlight'>" . htmlspecialchars($row["type"]) . "</span></p>";
                echo "<p class='date'>Date: <span class='highlight'>" . htmlspecialchars($row["date"]) . "</span></p>";
                echo "<p class='slots-left'>Slots Left: <span class='highlight'>" . htmlspecialchars($row["slots"]) . "</span></p>";
                echo "<p class='registration-ends'>Registration ends: <span class='highlight'>" . htmlspecialchars($row["registration"]) . "</span></p>";
                echo "<div class='prize-pool'>";
                echo "<h2>Prize Pool</h2>";
                echo "<p>₹" . htmlspecialchars($row["prize"]) . "</p>";
                echo "</div>";
                echo "</div>";

                if ($user_type == 'organizer') {
                    echo "<form action='modify_tournament.php' method='get'>";
                    echo "<input type='hidden' name='tournament_id' value='" . htmlspecialchars($row["tournament_id"]) . "'>";
                    echo "<button type='submit' class='register-button'>Update Tournament</button>";
                    echo "</form>";
                } elseif ($user_type == 'team_manager') {
                    echo "<form action='register_tournament.php' method='get'>";
                    echo "<input type='hidden' name='tournament_id' value='" . htmlspecialchars($row["tournament_id"]) . "'>";
                    echo "<button type='submit' class='register-button'>Register Tournament</button>";
                    echo "</form>";
                }

                echo "</section>";
            }
        } else {
            echo "No tournaments found.";
        }
        $conn->close();
        ?>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>
</body>
</html>
