<?php
session_start();
include("../config.php");

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login_form,php");
    exit();
}

// Fetch all users
$query = $conn->prepare("SELECT * FROM users");
$query->execute();
$users = $query->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($user = $users->fetch_assoc()) {
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$user['first_name']}</td>
                    <td>{$user['last_name']}</td>
                    <td>{$user['username']}</td>
                    <td>{$user['email']}</td>
                    <td>{$user['user_type']}</td>
                    <td><a href='delete_user.php?id={$user['id']}'>Delete</a></td>
                </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>
