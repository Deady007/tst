<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("You must be logged in to create a team.");
}

$email = $_SESSION['email']; // Team manager's email

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $_POST['team_name'];

    if (empty($team_name) || empty($email)) {
        die("Team name and manager's email are required.");
    }

    // Create the team
    $stmt = $conn->prepare("INSERT INTO teams (team_name, created_by) VALUES (?, ?)");
    $stmt->bind_param("ss", $team_name, $email);

    if ($stmt->execute()) {
        $team_id = $stmt->insert_id; // Get the newly created team ID
        echo "<p class='success-message'>Team created successfully. You will be redirected to generate an invite code.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'generate_code.php?team_id=$team_id';
            }, 2000); // Redirect after 2 seconds
        </script>";
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3a6186, #89253e);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        header {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logo {
            width: 250px; /* Logo size */
            height: auto; /* Maintain aspect ratio */
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        main {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        label {
            font-weight: 500;
            color: #f0f0f0;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #ff416c;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #ff4b2b;
            transform: translateY(-3px);
        }

        .success-message, .error-message {
            font-size: 1.1rem;
            font-weight: 500;
            margin-top: 1rem;
            animation: fadeInUp 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            main {
                padding: 30px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo">
    </header>
    <main>
        <h1>Create Team</h1>
        <form action="create_team.php" method="post">
            <label for="team_name">Team Name:</label>
            <input type="text" id="team_name" name="team_name" required>
            <button type="submit">Create Team</button>
        </form>
    </main>
</body>
</html>
