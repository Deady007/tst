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

// Handle form submission for adding a team
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_team'])) {
    $tournament_id = $_POST['tournament_id'];
    $team_id = $_POST['team_id'];

    if (!empty($tournament_id) && !empty($team_id)) {
        $add_query = $conn->prepare("INSERT INTO tournament_registrations (tournament_id, team_id) VALUES (?, ?)");
        $add_query->bind_param("ii", $tournament_id, $team_id);

        if ($add_query->execute()) {
            echo "<p class='success'>Team added successfully.</p>";
        } else {
            echo "<p class='error'>Error: " . $add_query->error . "</p>";
        }

        $add_query->close();
    } else {
        echo "<p class='error'>Please fill in all fields.</p>";
    }
}

// Handle form submission for deleting a team
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_team'])) {
    $tournament_id = $_POST['tournament_id'];
    $team_id = $_POST['team_id'];

    if (!empty($tournament_id) && !empty($team_id)) {
        $delete_query = $conn->prepare("DELETE FROM tournament_registrations WHERE tournament_id = ? AND team_id = ?");
        $delete_query->bind_param("ii", $tournament_id, $team_id);

        if ($delete_query->execute()) {
            echo "<p class='success'>Team removed successfully.</p>";
        } else {
            echo "<p class='error'>Error: " . $delete_query->error . "</p>";
        }

        $delete_query->close();
    } else {
        echo "<p class='error'>Please fill in all fields.</p>";
    }
}

// Fetch all tournaments and teams for dropdowns
$tournaments = $conn->query("SELECT tournament_id, name FROM tournaments");
$teams = $conn->query("SELECT team_id, team_name FROM teams");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Delete Team from Tournaments</title>
</head>
<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

header {
    background: #007bff;
    padding: 10px 0;
    text-align: center;
}

.logo {
    max-width: 150px;
}

main {
    padding: 20px;
    margin: 0 auto;
    max-width: 800px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

section {
    margin-bottom: 20px;
}

h2 {
    color: #007bff;
}

label {
    display: block;
    margin: 10px 0 5px;
}

select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

button {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background: #0056b3;
}

.success {
    color: green;
}

.error {
    color: red;
}

footer {
    text-align: center;
    padding: 10px 0;
    background: #007bff;
    color: white;
}

</style>
<body>
    <header><a href="dashboard.php">
        <img src="logo.png" alt="Logo" class="logo">
        </a>
    </header>
    <main>
        <h1>Add or Remove Teams from Tournaments</h1>

        <!-- Form to Add Team -->
        <section>
            <h2>Add Team to Tournament</h2>
            <form action="manage_teams.php" method="post">
                <label for="tournament_id">Tournament:</label>
                <select id="tournament_id" name="tournament_id" required>
                    <option value="">Select Tournament</option>
                    <?php while ($row = $tournaments->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['tournament_id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="team_id">Team:</label>
                <select id="team_id" name="team_id" required>
                    <option value="">Select Team</option>
                    <?php while ($row = $teams->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['team_id']); ?>"><?= htmlspecialchars($row['team_name']); ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="add_team">Add Team</button>
            </form>
        </section>

        <!-- Form to Delete Team -->
        <section>
            <h2>Remove Team from Tournament</h2>
            <form action="manage_teams.php" method="post">
                <label for="tournament_id">Tournament:</label>
                <select id="tournament_id" name="tournament_id" required>
                    <option value="">Select Tournament</option>
                    <?php
                    // Reset tournaments result to loop again
                    $tournaments->data_seek(0);
                    while ($row = $tournaments->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['tournament_id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="team_id">Team:</label>
                <select id="team_id" name="team_id" required>
                    <option value="">Select Team</option>
                    <?php
                    // Reset teams result to loop again
                    $teams->data_seek(0);
                    while ($row = $teams->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['team_id']); ?>"><?= htmlspecialchars($row['team_name']); ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="delete_team">Remove Team</button>
            </form>
        </section>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>
</body>
</html>

<?php
// Close connections
$conn->close();
?>
