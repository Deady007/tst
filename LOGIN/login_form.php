<?php
session_start(); // Start the session

// Check for errors in session and store them in a variable
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear error message from session
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furious eSports - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="login.php" method="post">
                <h1>Sign In</h1>
                <input type="text" name="email" placeholder="Email or Username" required />
                <div class="input-container">
                    <input type="password" name="password" id="login-password" placeholder="Password" required />
                    <span class="view-password" id="login-password-eye">👁️</span>
                </div>
                <button type="submit">Sign In</button>
                
                <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
                
                <!-- Area for displaying error messages -->
                <?php if (!empty($error_message)): ?>
                    <div class="error-messages">
                        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                    </div>
                <?php endif; ?>
            </form>

            <p class="switch-form">Don't have an account? <a href="register_form.php">Create one here!</a></p>
        </div>
    </div>
    <script>
        // Password view toggle for login
        const loginPasswordInput = document.getElementById('login-password');
        const loginPasswordIcon = document.getElementById('login-password-eye');
        loginPasswordIcon.addEventListener('click', () => {
            if (loginPasswordInput.type === 'password') {
                loginPasswordInput.type = 'text';
                loginPasswordIcon.innerHTML = '🙈'; // Change to hide icon
            } else {
                loginPasswordInput.type = 'password';
                loginPasswordIcon.innerHTML = '👁️'; // Change to show icon
            }
        });
    </script>
</body>
</html>
