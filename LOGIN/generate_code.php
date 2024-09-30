// generate_code.php
<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to generate an invite code.");
}

$email = $_SESSION['email']; // Team manager's email

// Get team ID from the request
$team_id = $_GET['team_id'];

// Generate a 4-character invite code
$invite_code = substr(strtoupper(uniqid()), 0, 4);

// Insert the invite code into the database
$stmt = $conn->prepare("INSERT INTO team_invitations (invite_code, team_id) VALUES (?, ?)");
$stmt->bind_param("si", $invite_code, $team_id);

if ($stmt->execute()) {
    echo "<p>Invite code generated: " . $invite_code . "</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'dashboard.php'; // Redirect to dashboard
        }, 2000);
    </script>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
