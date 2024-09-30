<?php
session_start();
include("../config.php");

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login_form,php");
    exit();
}

// Fetch all teams
$query = $conn->prepare("SELECT * FROM teams");
$query->execute();
$teams = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Teams</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Teams</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Team Name</th>
                <th>Manager</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($team = $teams->fetch_assoc()) {
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$team['team_name']}</td>
                    <td>{$team['manager']}</td>
                    <td><a href='delete_team.php?id={$team['id']}'>Delete</a></td>
                </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>
