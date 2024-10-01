<?php
session_start();
include 'config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to generate an invite code.");
}

$email = $_SESSION['email']; // Team manager's email

// Get team ID from the request
$team_id = $_GET['team_id'];

// Function to generate a unique 4-character invite code
function generateUniqueInviteCode($conn) {
    $attempts = 0; // Initialize attempts counter

    do {
        $attempts++;

        // Generate a random 4-character invite code
        $invite_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4)); // Using md5 hash for randomness

        // Check if the code already exists in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM team_invitations WHERE invite_code = ?");
        $stmt->bind_param("s", $invite_code);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Break if we reach 10 attempts
        if ($attempts >= 10) {
            die("<p>Error: Unable to generate a unique invite code after 10 attempts.</p>");
        }

    } while ($count > 0); // Repeat until a unique code is found

    return $invite_code; // Return the unique invite code
}

// Generate a unique invite code
$invite_code = generateUniqueInviteCode($conn);

// Insert the invite code into the database
$stmt = $conn->prepare("INSERT INTO team_invitations (invite_code, team_id) VALUES (?, ?)");
$stmt->bind_param("si", $invite_code, $team_id);

if ($stmt->execute()) {
    echo "<p>Invite code generated: " . htmlspecialchars($invite_code) . "</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'my_team.php'; // Redirect to dashboard
        }, 5000); // Redirect after 5 seconds
    </script>";
} else {
    echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
}

// Clean up
$stmt->close();
$conn->close();
?>
