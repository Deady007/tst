<?php
session_start(); // Start the session
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
include 'config.php';

// Initialize an array to store errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $first_name = isset($_POST['first_name']) ? htmlspecialchars(trim($_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? htmlspecialchars(trim($_POST['last_name'])) : '';
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $user_type = isset($_POST['user_type']) ? htmlspecialchars(trim($_POST['user_type'])) : '';

    // Basic validation
    if (empty($username)) {
        $errors[] = "Username is required!";
    }
    if (empty($email)) {
        $errors[] = "Email is required!";
    }
    if (empty($password)) {
        $errors[] = "Password is required!";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // Password policy check
    if (strlen($password) < 8 || 
        !preg_match('/[A-Za-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "Password must be at least 8 characters long and include letters, numbers, and special characters.";
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if username already exists
        $checkUsername = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $resultUsername = $checkUsername->get_result();

        if ($resultUsername->num_rows > 0) {
            $errors[] = "Username already exists!";
        }

        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $resultEmail = $checkEmail->get_result();

        if ($resultEmail->num_rows > 0) {
            $errors[] = "Email address already exists!";
        }

        if (empty($errors)) {
            // Insert new user
            $insertQuery = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("ssssss", $first_name, $last_name, $username, $email, $hashed_password, $user_type);

            if ($insertQuery->execute()) {
                // Close the statements
                $insertQuery->close();
                $checkUsername->close();
                $checkEmail->close();

                // Redirect to login_form,php after successful registration
                header("Location: login_form.php");
                exit();
            } else {
                $errors[] = "Error: " . $conn->error;
            }
        }

        // Close the statements
        $checkUsername->close();
        $checkEmail->close();
    }

    // Store errors in session variable
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        // Redirect back to the index page to show errors
        header("Location: register_form.php");
        exit();
    }
}
?>
