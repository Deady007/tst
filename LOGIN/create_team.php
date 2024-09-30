<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to create a team.");
}

$email = $_SESSION['email']; // Team manager's email

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $_POST['team_name'];

    if (empty($team_name) || empty($email)) {
        die("Team name and manager's email are required.");
    }

    // Create the team
    $stmt = $conn->prepare("INSERT INTO teams (team_name, created_by) VALUES (?, ?)");
    $stmt->bind_param("ss", $team_name, $email);

    if ($stmt->execute()) {
        $team_id = $stmt->insert_id; // Get the newly created team ID
        echo "<p>Team created successfully. You will be redirected to generate an invite code.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'generate_code.php?team_id=$team_id';
            }, 2000); // Redirect after 2 seconds
        </script>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
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
    <title>Create Team</title>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo">
    </header>
    <main>
        <h1>Create Team</h1>
        <form action="create_team.php" method="post">
            <label for="team_name">Team Name:</label>
            <input type="text" id="team_name" name="team_name" required>
            <button type="submit">Create Team</button>
        </form>
    </main>
</body>
</html>
