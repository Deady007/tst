<?php
// Start session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php"); // Redirect to the dashboard if logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

header {
    background: #007bff;
    padding: 20px 0;
    text-align: center;
    color: white;
}

.logo {
    max-width: 150px;
}

main {
    padding: 20px;
    margin: 0 auto;
    max-width: 600px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

section {
    margin-bottom: 20px;
}

h2 {
    color: #007bff;
}

ul {
    list-style-type: none;
    padding-left: 0;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

footer {
    text-align: center;
    padding: 10px 0;
    background: #007bff;
    color: white;
    position: relative;
    bottom: 0;
    width: 100%;
}

</style>
<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo">
        <h1>Forgot Password</h1>
    </header>
    <main>
        <section>
            <h2>Password Reset</h2>
            <p>If you have forgotten your password, please contact the admin for assistance.</p>
            <p>You can reach the admin at:</p>
            <ul>
                <li>Email: <a href="mailto:admin@gmail.com">admin@gmail.com</a></li>
                <li>Phone: +91-23456-78901</li>
            </ul>
            <p>Thank you for your understanding!</p>
            <p><a href="login_form.php">Return to Login Page</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Furious eSports</p>
    </footer>
</body>
</html>
