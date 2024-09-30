<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Initialize error message
$error_message = '';

// Database configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_or_username = $_POST['email']; // User can input email or username here
    $password = $_POST['password'];

    // Prepare and execute query to get user details (email or username)
    $loginQuery = $conn->prepare("
        SELECT * FROM users 
        WHERE email = ? OR username = ?"); // Check for both email or username
    $loginQuery->bind_param("ss", $email_or_username, $email_or_username); // Bind both email and username to the same input
    $loginQuery->execute();
    $result = $loginQuery->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['is_admin'] = $user['is_admin']; // Store admin status

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Set error message for invalid password
            $_SESSION['error_message'] = "Invalid Email/Username or Password!";
            header("Location: login_form.php");
            exit();
        }
    } else {
        // Set error message for invalid email/username
        $_SESSION['error_message'] = "Invalid Email/Username or Password!";
        header("Location: login_form.php");
        exit();
    }
}
?>
