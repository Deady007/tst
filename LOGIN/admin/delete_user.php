<?php
session_start();
include("../config.php");

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login_form,php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Assuming the `created_by` column in `tournament_registrations` holds a reference to the user (such as a username or email),
    // you need to get the user's identifying value first
    $getUserQuery = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $getUserQuery->bind_param("i", $user_id);
    $getUserQuery->execute();
    $result = $getUserQuery->get_result();
    $user = $result->fetch_assoc();
    $created_by = $user['email']; // Or use `username` or other identifier based on your DB structure

    // Now delete the user's related records from `tournament_registrations` based on `created_by`
    $deleteRegistrationsQuery = $conn->prepare("DELETE FROM tournament_registrations WHERE created_by = ?");
    $deleteRegistrationsQuery->bind_param("s", $created_by);
    $deleteRegistrationsQuery->execute();

    // Finally, delete the user from the `users` table
    $deleteUserQuery = $conn->prepare("DELETE FROM users WHERE id = ?");
    $deleteUserQuery->bind_param("i", $user_id);
    $deleteUserQuery->execute();

    header("Location: manage_users.php");
    exit();
}
?>
