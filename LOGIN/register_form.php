<?php
session_start(); // Start the session

// Check for errors in session and store them in a variable
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

// Clear errors from session
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furious eSports - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="register.php" method="post">
                <h1>Sign Up</h1>
                <input type="text" name="first_name" placeholder="First Name" required />
                <input type="text" name="last_name" placeholder="Last Name" required />
                <input type="text" name="username" placeholder="Username" required />
                <input type="email" name="email" placeholder="Email" required />

                <div class="input-container">
                    <input type="password" name="password" id="register-password" placeholder="Password" required />
                    <span class="view-password" id="register-password-eye">👁️</span>
                </div>

                <div class="input-container">
                    <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm Password" required />
                    <span class="view-password" id="confirm-password-eye">👁️</span>
                </div>

                <select name="user_type" required>
                    <option value="" disabled selected>User Type</option>
                    <option value="player">Player</option>
                    <option value="team_manager">Team Manager</option>
                    <option value="organizer">Organizer</option>
                </select>

                <button type="submit">Sign Up</button>
                
                <!-- Area for displaying error messages -->
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </form>

            <p class="switch-form">Already have an account? <a href="login_form.php">Log in here!</a></p>
        </div>
    </div>
    <script>
        // Password view toggle for registration
        const registerPasswordInput = document.getElementById('register-password');
        const registerPasswordIcon = document.getElementById('register-password-eye');
        registerPasswordIcon.addEventListener('click', () => {
            if (registerPasswordInput.type === 'password') {
                registerPasswordInput.type = 'text';
                registerPasswordIcon.innerHTML = '🙈'; // Change to hide icon
            } else {
                registerPasswordInput.type = 'password';
                registerPasswordIcon.innerHTML = '👁️'; // Change to show icon
            }
        });

        // Password view toggle for confirmation
        const confirmPasswordInput = document.getElementById('confirm-password');
        const confirmPasswordIcon = document.getElementById('confirm-password-eye');
        confirmPasswordIcon.addEventListener('click', () => {
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmPasswordIcon.innerHTML = '🙈'; // Change to hide icon
            } else {
                confirmPasswordInput.type = 'password';
                confirmPasswordIcon.innerHTML = '👁️'; // Change to show icon
            }
        });
    </script>
</body>
</html>
