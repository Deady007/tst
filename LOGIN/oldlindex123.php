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
    <title>Furious eSports - Login & Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Registration Form -->
        <div class="form-container sign-up-container">
            <form action="register.php" method="post">
                <h1>Sign Up</h1>
                <input type="text" name="first_name" placeholder="First Name" required />
                <input type="text" name="last_name" placeholder="Last Name" required />
                <input type="text" name="username" placeholder="Username" required />
                <input type="email" name="email" placeholder="Email" required />
                
                <div class="input-container">
                    <input type="password" name="password" id="password" placeholder="Password" required />
                    <span class="icon" id="password-icon">👁️</span>
                </div>

                <div class="input-container">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                    <span class="icon" id="confirm-password-icon">👁️</span>
                </div>
                
                <!-- Area for displaying error messages -->
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <select name="user_type" required>
                    <option value="" disabled selected>User Type</option>
                    <option value="player">Player</option>
                    <option value="team_manager">Team Manager</option>
                    <option value="organizer">Organizer</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit">Sign Up</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container sign-in-container">
            <form action="login.php" method="post">
                <h1>Sign In</h1>
                <input type="text" name="email" placeholder="Email or Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign In</button>
            </form>
        </div>

        <!-- Overlay for transitioning between forms -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>Your Legacy Continues! Log In to Compete, Win, and Dominate!</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Start Your eSports Adventure Here! Create Your Account and Rise to the Top!</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.querySelector('.container');

        // Event listeners for switching between forms
        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        // Password show/hide toggle
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordIcon = document.getElementById('password-icon');
        const confirmPasswordIcon = document.getElementById('confirm-password-icon');

        passwordIcon.addEventListener('click', () => {
            togglePasswordVisibility(passwordInput, passwordIcon);
        });

        confirmPasswordIcon.addEventListener('click', () => {
            togglePasswordVisibility(confirmPasswordInput, confirmPasswordIcon);
        });

        // Function to toggle password visibility
        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '🙈'; // Change to hide icon
            } else {
                input.type = 'password';
                icon.innerHTML = '👁️'; // Change to show icon
            }
        }
    </script>
</body>
</html>
