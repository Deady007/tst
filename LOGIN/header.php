<!-- header.php -->
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
                <?php if ($userType == 'player' || $userType == 'team_manager' || $userType == 'organizer') { ?>
                    <a href="tournament/tournaments.php">Tournaments</a>
                <?php } ?>
                <?php if ($userType == 'player') { ?>
                    <a href="my_profile.php">My Profile</a>
                    <a href="join_team.php">Join Team</a>
                    <a href="achievements.php">Achievements</a>
                <?php } ?>
                
                <?php if ($userType == 'team_manager') { ?>
                    <a href="create_team.php">Create Team</a>
                    <a href="my_team.php">My Team</a>
                    <a href="my_achievements.php">Achievements</a>
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
