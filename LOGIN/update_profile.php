<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: LOGIN/login_form,php");
    exit();
}

// Fetch user details
$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");
$user = mysqli_fetch_array($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission and update profile
    $profile_photo = $_FILES['profile_photo']['name'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $date_of_birth = $_POST['date_of_birth'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $playing_game = $_POST['playing_game'];
    $player_role = $_POST['player_role'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $playing_since = $_POST['playing_since'];

    // Handle profile photo upload
    if (!empty($profile_photo)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_photo);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);
    } else {
        $target_file = $user['profile_photo'];
    }

    // Update the user's profile
    $updateQuery = "UPDATE `users` SET 
                    profile_photo='$target_file', 
                    first_name='$first_name', 
                    last_name='$last_name', 
                    username='$username', 
                    date_of_birth='$date_of_birth', 
                    state='$state', 
                    city='$city', 
                    playing_game='$playing_game', 
                    player_role='$player_role', 
                    phone_number='$phone_number', 
                    gender='$gender', 
                    playing_since='$playing_since', 
                    profile_complete=1 
                    WHERE email='$email'";

    mysqli_query($conn, $updateQuery);

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h2>Complete Your Profile</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="profile_photo">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo">
            <br>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <br>
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required>
            <br>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required>
            <br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
            <br>
            <label for="playing_game">Playing Game:</label>
            <input type="text" id="playing_game" name="playing_game" value="<?php echo htmlspecialchars($user['playing_game']); ?>" required>
            <br>
            <label for="player_role">Player Role:</label>
            <input type="text" id="player_role" name="player_role" value="<?php echo htmlspecialchars($user['player_role']); ?>" required>
            <br>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            <br>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
            <br>
            <label for="playing_since">Playing Since:</label>
            <input type="date" id="playing_since" name="playing_since" value="<?php echo htmlspecialchars($user['playing_since']); ?>" required>
            <br>
            <button type="submit">Save Profile</button>
        </form>
    </div>
</body>
</html>
