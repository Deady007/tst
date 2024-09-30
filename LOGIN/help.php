<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login_form,php"); // Redirect to login page if not logged in
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help - Furious eSports Management System</title>
    <link rel="stylesheet" href="help.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Furious eSports Logo" class="logo">
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>

            </ul>
        </nav>
    </header>

    <main class="help-content">
        <h1>Help & Support</h1>
        <p>Welcome to the Furious eSports Management System Help Page! Here you can find information and guidance on how to use the system effectively.</p>

        <section>
            <h2>Getting Started</h2>
            <p>To start using the system, log in with your credentials. If you don’t have an account, please register first.</p>
            <p>Once logged in, you can create or join tournaments, manage your team, and access various features from the dashboard.</p>
        </section>

        <section>
            <h2>Tournament Registration</h2>
            <p>To register for a tournament, navigate to the <strong>Tournaments</strong> section. Select a tournament and click on the <strong>Register</strong> button. Make sure to check the registration deadlines and tournament details.</p>
        </section>

        <section>
            <h2>Managing Your Team</h2>
            <p>In the <strong>My Team</strong> section, you can view and manage your team members. You can add, edit, or remove players as needed. Make sure to save changes after editing.</p>
        </section>

        <section>
            <h2>Common Issues</h2>
            <h3>Can't Log In?</h3>
            <p>If you're having trouble logging in, ensure that your email and password are correct. If you forgot your password, use the "Forgot Password" option.</p>

            <h3>Registration Not Saving?</h3>
            <p>If your tournament registration is not saving, please ensure all required fields are filled out and that the tournament is not full. If the issue persists, contact support.</p>
        </section>

        <section>
            <h2>Contact Support</h2>
            <p>If you need further assistance, feel free to reach out to our support team:</p>
            <ul>
                <li>Email: support@furiousesports.com</li>
                <li>Phone: +1 (234) 567-890</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>© 2024 Furious eSports. All rights reserved.</p>
    </footer>
</body>
</html>
