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
    <title>Furious eSports - Login/Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form" id="register-form">
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

            <div class="form" id="login-form">
                <form action="login.php" method="post">
                    <h1>Sign In</h1>
                    <input type="text" name="email" placeholder="Email or Username" required />
                    <div class="input-container">
                        <input type="password" name="password" id="login-password" placeholder="Password" required />
                        <span class="view-password" id="login-password-eye">👁️</span>
                    </div>
                    <button type="submit">Sign In</button>
                    
                    <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
                </form>
            </div>
            
            <div class="switch-form">
                <button id="switchToRegister">Create Account</button>
                <button id="switchToLogin">Already Have an Account? Log In</button>
            </div>
        </div>
    </div>
    <script>
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');
        const registerForm = document.getElementById('register-form');
        const loginForm = document.getElementById('login-form');

        // Event listeners for switching between forms
        switchToRegister.addEventListener('click', () => {
            registerForm.style.display = 'block';
            loginForm.style.display = 'none';
        });

        switchToLogin.addEventListener('click', () => {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });

        // Show login form by default
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';

        // Toggle password visibility
        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '🙈'; // Change to hide icon
            } else {
                input.type = 'password';
                icon.innerHTML = '👁️'; // Change to show icon
            }
        }

        // Password view toggle for registration
        const registerPasswordInput = document.getElementById('register-password');
        const registerPasswordIcon = document.getElementById('register-password-eye');
        registerPasswordIcon.addEventListener('click', () => {
            togglePasswordVisibility(registerPasswordInput, registerPasswordIcon);
        });

        // Password view toggle for confirmation
        const confirmPasswordInput = document.getElementById('confirm-password');
        const confirmPasswordIcon = document.getElementById('confirm-password-eye');
        confirmPasswordIcon.addEventListener('click', () => {
            togglePasswordVisibility(confirmPasswordInput, confirmPasswordIcon);
        });

        // Password view toggle for login
        const loginPasswordInput = document.getElementById('login-password');
        const loginPasswordIcon = document.getElementById('login-password-eye');
        loginPasswordIcon.addEventListener('click', () => {
            togglePasswordVisibility(loginPasswordInput, loginPasswordIcon);
        });
    </script>
</body>
</html>
