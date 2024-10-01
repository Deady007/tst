<?php
session_start();
include 'config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login_form,php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user data from the database
$email = isset($_GET['email']) ? $_GET['email'] : $_SESSION['email']; // Check if an email is passed, else use the session email
$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>

    <div class="profile-container">
    <a href="dashboard.php" class="dashboard-btn">Dashboard</a>
        <h2>Profile</h2> <!-- Updated header -->
        <div class="profile-photo">
            <?php if (!empty($user['profile_photo'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo">
            <?php else: ?>
                <img src="default_profile.png" alt="Default Profile Photo">
            <?php endif; ?>
        </div>
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($user['state']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>Playing Game:</strong> <?php echo htmlspecialchars($user['playing_game']); ?></p>
            <p><strong>Player Role:</strong> <?php echo htmlspecialchars($user['player_role']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
            <p><strong>Playing Since:</strong> <?php echo htmlspecialchars($user['playing_since']); ?></p>
        </div>
        
        <a href="update_profile.php" class="update-btn">Update My Profile</a>
    </div>

    <!-- Footer with account created and updated info -->
    <div class="profile-footer">
        <p><strong>Account Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
        <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($user['updated_at']); ?></p>
    </div>
</body>
</html>
