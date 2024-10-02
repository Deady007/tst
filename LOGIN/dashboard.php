<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login_form.php"); // Redirect to login if not logged in
    exit();
}
// Fetch the user type or admin status from session
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $isAdmin = true;
} else {
    $isAdmin = false;
}

// Fetch user details using prepared statements
$email = $_SESSION['email'];
$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userType = $user['user_type'];
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furious eSports</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <img src="logo.png" alt="Logo">
            <div class="nav-links">
    <a href="dashboard.php" class="dashboard">Dashboard</a> <!-- Added Dashboard Button -->
    <?php if ($userType == 'player' || $userType == 'team_manager' || $userType == 'organizer') { ?>
        <a href="tournament/tournaments.php">Tournaments</a>
    <?php } ?>
    <?php if ($userType == 'player') { ?>
        <a href="my_profile.php">My Profile</a>
        <a href="join_team.php">Join Team</a>
    <?php } ?>
    <?php if ($userType == 'team_manager') { ?>
        <a href="create_team.php">Create Team</a>
        <a href="my_team.php">My Team</a>
        <a href="my_tournaments.php">My Tournaments</a>
    <?php } ?>
    <?php if ($userType == 'organizer') { ?>
        <a href="tournament/create_tournament.php">Create Tournament</a>
        <a href="manage_teams.php">Manage Teams</a>
        <a href="tournament/modify_tournament.php">Modify Tournament</a>
    <?php } ?>
    <?php if ($isAdmin) { ?>
        <a href="admin/manage_users.php">Manage Users</a>
        <a href="admin/manage_teams.php">Manage Teams</a>
        <a href="admin/manage_tournaments.php">Manage Tournaments</a>
    <?php } ?>                
    <a href="help.php">Help</a>
    <a href="logout.php">Logout</a>
</div>

        </div>
        <div class="content">
            <h1>Welcome, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</h1>
            <p>An Ultimate eSports Platform</p>
            <p>Furious eSports management involves overseeing teams, players, and events within the competitive gaming industry. This includes handling logistics, scheduling, player contracts, sponsorships, and ensuring smooth operations for tournaments and online broadcasts.</p>
            <div class="buttons">
                <?php if ($userType == 'player') { ?>
                    <a href="my_profile.php">Get Started</a>
                <?php } ?>
                <?php if ( $userType == 'team_manager' ) { ?>
                    <a href="tournament/register_tournament.php">Get Started</a>
                <?php } ?>
                <?php if ($userType == 'organizer') { ?>
                    <a href="tournament/create_tournament.php">Get Started</a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
